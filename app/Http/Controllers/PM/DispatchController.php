<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\Dispatch;
use App\Models\DispatchAssociate;
use App\Models\Item;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DispatchController extends Controller
{
    /**
     * Display a listing of dispatches
     */
    public function index()
    {
        $currentUser = Auth::guard('pm')->user();

        $dispatches = Dispatch::with(['destinationOffice', 'creator', 'dispatchAssociates'])
            ->where('location_id', $currentUser->location_id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Debug logging to check if manifest_id is properly loaded
        foreach($dispatches as $dispatch) {
            if(empty($dispatch->manifest_id)) {
                Log::warning("Dispatch {$dispatch->id} has empty manifest_id in controller", [
                    'manifest_id' => $dispatch->manifest_id,
                    'necklabel' => $dispatch->necklabel,
                    'created_at' => $dispatch->created_at
                ]);
            }
        }

        return view('pm.dispatch.index', compact('dispatches'));
    }

    /**
     * Show the form for creating a new dispatch
     */
    public function create()
    {
        $currentUser = Auth::guard('pm')->user();

        // Get all other locations for destination selection
        $deliveryOffices = Location::where('id', '!=', $currentUser->location_id)
            ->orderBy('name')
            ->get();

        // Get available items for dispatch (accepted items that haven't been dispatched yet)
        $availableItems = Item::where('status', 'accept')
            ->whereDoesntHave('dispatchAssociates', function($query) {
                $query->whereIn('status', ['dispatch', 'received']);
            })
            ->with(['itemBulk'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pm.dispatch.create', compact('deliveryOffices', 'availableItems'));
    }

    /**
     * Store a newly created dispatch with items and neck label
     */
    public function store(Request $request)
    {
        $request->validate([
            'destination_office' => 'required|exists:locations,id',
            'necklabel' => 'required|string|max:255',
            'items' => 'required|string|min:1',
        ], [
            'items.required' => 'Please add at least one item to the dispatch.',
            'items.min' => 'Please add at least one item to the dispatch.',
        ]);

        $currentUser = Auth::guard('pm')->user();

        try {
            DB::beginTransaction();

            // Generate unique manifest ID
            $manifestId = 'MAN' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            $dispatch = Dispatch::create([
                'necklabel' => $request->necklabel,
                'manifest_id' => $manifestId,
                'destination_office' => $request->destination_office,
                'created_by' => $currentUser->id,
                'location_id' => $currentUser->location_id,
            ]);

            // Decode items array from JSON
            $itemIds = json_decode($request->items);

            if (!is_array($itemIds) || empty($itemIds)) {
                throw new \Exception('No items selected for dispatch');
            }

            // Add all selected items to dispatch
            $addedCount = 0;
            foreach ($itemIds as $itemId) {
                // Verify item is still available
                $item = Item::where('id', $itemId)
                    ->where('status', 'accept')
                    ->whereDoesntHave('dispatchAssociates', function($query) {
                        $query->whereIn('status', ['dispatch', 'received']);
                    })
                    ->first();

                if ($item) {
                    DispatchAssociate::create([
                        'item_id' => $item->id,
                        'dispatch_id' => $dispatch->id,
                        'status' => 'dispatch',
                        'updated_by' => $currentUser->id,
                    ]);

                    // Update item status
                    $item->update(['status' => 'dispatched']);
                    $addedCount++;
                }
            }

            if ($addedCount === 0) {
                throw new \Exception('No valid items were added to the dispatch');
            }

            DB::commit();

            return redirect()->route('pm.dispatch.manifest', $dispatch->id)
                ->with('success', 'Postal bag created successfully with ' . $addedCount . ' items!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating dispatch', [
                'error' => $e->getMessage(),
                'user_id' => $currentUser->id
            ]);

            return back()->with('error', 'Error creating postal bag: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for adding items to dispatch
     */
    public function addItems($id)
    {
        $dispatch = Dispatch::with(['destinationOffice', 'dispatchAssociates.item'])
            ->findOrFail($id);

        $currentUser = Auth::guard('pm')->user();

        // Verify dispatch belongs to current user's location
        if ($dispatch->location_id !== $currentUser->location_id) {
            abort(403, 'Unauthorized access to this dispatch.');
        }

        // Get available items for dispatch (accepted items that haven't been dispatched yet)
        $availableItems = Item::where('status', 'accept')
            ->whereDoesntHave('dispatchAssociates', function($query) {
                $query->whereIn('status', ['dispatch', 'received']);
            })
            ->with(['itemBulk'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pm.dispatch.add-items', compact('dispatch', 'availableItems'));
    }

    /**
     * Add item to dispatch via barcode
     */
    public function addItemByBarcode(Request $request, $id)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $dispatch = Dispatch::findOrFail($id);
        $currentUser = Auth::guard('pm')->user();

        // Verify dispatch belongs to current user's location
        if ($dispatch->location_id !== $currentUser->location_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            // Find item by barcode
            $item = Item::where('barcode', $request->barcode)
                ->where('status', 'accept')
                ->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found or not available for dispatch'
                ]);
            }

            // Check if item is already dispatched
            $alreadyDispatched = DispatchAssociate::where('item_id', $item->id)
                ->whereIn('status', ['dispatch', 'received'])
                ->exists();

            if ($alreadyDispatched) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item already dispatched'
                ]);
            }

            DB::beginTransaction();

            // Add item to dispatch
            DispatchAssociate::create([
                'item_id' => $item->id,
                'dispatch_id' => $dispatch->id,
                'status' => 'dispatch',
                'updated_by' => $currentUser->id,
            ]);

            // Update item status
            $item->update(['status' => 'dispatched']);

            DB::commit();

            // Return item details for frontend display
            return response()->json([
                'success' => true,
                'message' => 'Item added to dispatch successfully',
                'item' => [
                    'id' => $item->id,
                    'barcode' => $item->barcode,
                    'receiver_name' => $item->receiver_name,
                    'receiver_address' => $item->receiver_address,
                    'amount' => $item->amount,
                    'weight' => $item->weight,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding item to dispatch', [
                'error' => $e->getMessage(),
                'dispatch_id' => $id,
                'barcode' => $request->barcode,
                'user_id' => $currentUser->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error adding item: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove item from dispatch
     */
    public function removeItem(Request $request, $id)
    {
        $dispatch = Dispatch::findOrFail($id);
        $currentUser = Auth::guard('pm')->user();

        // Verify dispatch belongs to current user's location
        if ($dispatch->location_id !== $currentUser->location_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            DB::beginTransaction();

            $dispatchAssociate = DispatchAssociate::where('dispatch_id', $id)
                ->where('item_id', $request->item_id)
                ->first();

            if ($dispatchAssociate) {
                // Update item status back to accept
                Item::where('id', $request->item_id)->update(['status' => 'accept']);

                // Remove from dispatch
                $dispatchAssociate->delete();
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Item removed from dispatch']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error removing item']);
        }
    }

    /**
     * Generate and show manifest
     */
    public function generateManifest($id)
    {
        $dispatch = Dispatch::with([
            'destinationOffice',
            'creator',
            'location',
            'dispatchAssociates.item'
        ])->findOrFail($id);

        $currentUser = Auth::guard('pm')->user();

        // Verify dispatch belongs to current user's location
        if ($dispatch->location_id !== $currentUser->location_id) {
            abort(403, 'Unauthorized access to this dispatch.');
        }

        // Get items in this dispatch
        $dispatchedItems = $dispatch->dispatchAssociates()->with('item')->get();

        return view('pm.dispatch.manifest', compact('dispatch', 'dispatchedItems'));
    }

    /**
     * Print manifest
     */
    public function printManifest($id)
    {
        $dispatch = Dispatch::with([
            'destinationOffice',
            'creator',
            'location',
            'dispatchAssociates.item'
        ])->findOrFail($id);

        $currentUser = Auth::guard('pm')->user();

        // Verify dispatch belongs to current user's location
        if ($dispatch->location_id !== $currentUser->location_id) {
            abort(403, 'Unauthorized access to this dispatch.');
        }

        // Get items in this dispatch
        $dispatchedItems = $dispatch->dispatchAssociates()->with('item')->get();

        return view('pm.dispatch.print-manifest', compact('dispatch', 'dispatchedItems'));
    }

    /**
     * Display the specified dispatch
     */
    public function show(string $id)
    {
        $dispatch = Dispatch::with([
            'destinationOffice',
            'creator',
            'location',
            'dispatchAssociates.item'
        ])->findOrFail($id);

        $currentUser = Auth::guard('pm')->user();

        // Verify dispatch belongs to current user's location
        if ($dispatch->location_id !== $currentUser->location_id) {
            abort(403, 'Unauthorized access to this dispatch.');
        }

        return view('pm.dispatch.show', compact('dispatch'));
    }

    /**
     * Show the form for editing the specified dispatch
     */
    public function edit(string $id)
    {
        $dispatch = Dispatch::findOrFail($id);
        $currentUser = Auth::guard('pm')->user();

        // Verify dispatch belongs to current user's location
        if ($dispatch->location_id !== $currentUser->location_id) {
            abort(403, 'Unauthorized access to this dispatch.');
        }

        $deliveryOffices = Location::where('id', '!=', $currentUser->location_id)
            ->orderBy('name')
            ->get();

        return view('pm.dispatch.edit', compact('dispatch', 'deliveryOffices'));
    }

    /**
     * Update the specified dispatch
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'destination_office' => 'required|exists:locations,id',
            'necklabel' => 'required|string|max:255',
        ]);

        $dispatch = Dispatch::findOrFail($id);
        $currentUser = Auth::guard('pm')->user();

        // Verify dispatch belongs to current user's location
        if ($dispatch->location_id !== $currentUser->location_id) {
            abort(403, 'Unauthorized access to this dispatch.');
        }

        try {
            $dispatch->update([
                'destination_office' => $request->destination_office,
                'necklabel' => $request->necklabel,
            ]);

            return redirect()->route('pm.dispatch.show', $dispatch->id)
                ->with('success', 'Dispatch updated successfully');

        } catch (\Exception $e) {
            Log::error('Error updating dispatch', [
                'error' => $e->getMessage(),
                'dispatch_id' => $id,
                'user_id' => $currentUser->id
            ]);

            return back()->with('error', 'Error updating dispatch: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified dispatch
     */
    public function destroy(string $id)
    {
        $dispatch = Dispatch::findOrFail($id);
        $currentUser = Auth::guard('pm')->user();

        // Verify dispatch belongs to current user's location
        if ($dispatch->location_id !== $currentUser->location_id) {
            abort(403, 'Unauthorized access to this dispatch.');
        }

        try {
            DB::beginTransaction();

            // Update all items back to accept status
            $dispatchAssociates = DispatchAssociate::where('dispatch_id', $id)->get();
            foreach ($dispatchAssociates as $associate) {
                Item::where('id', $associate->item_id)->update(['status' => 'accept']);
            }

            // Delete dispatch associates
            DispatchAssociate::where('dispatch_id', $id)->delete();

            // Delete dispatch
            $dispatch->delete();

            DB::commit();

            return redirect()->route('pm.dispatch.index')
                ->with('success', 'Dispatch deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting dispatch', [
                'error' => $e->getMessage(),
                'dispatch_id' => $id,
                'user_id' => $currentUser->id
            ]);

            return back()->with('error', 'Error deleting dispatch: ' . $e->getMessage());
        }
    }
}
