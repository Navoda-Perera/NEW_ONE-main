<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\Postman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostmanController extends Controller
{
    /**
     * Display a listing of postmen for the authenticated PM's location.
     */
    public function index()
    {
        $user = Auth::guard('pm')->user();

        if (!$user) {
            return redirect()->route('pm.login')->with('error', 'Please login to access this page.');
        }

        $postmen = Postman::forLocation($user->location_id)
                          ->with(['location', 'creator', 'updater'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);

        return view('pm.postmen.index', compact('postmen'));
    }

    /**
     * Show the form for creating a new postman.
     */
    public function create()
    {
        $user = Auth::guard('pm')->user();

        if (!$user) {
            return redirect()->route('pm.login')->with('error', 'Please login to access this page.');
        }

        return view('pm.postmen.create');
    }

    /**
     * Store a newly created postman in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::guard('pm')->user();

        if (!$user) {
            return redirect()->route('pm.login')->with('error', 'Please login to access this page.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nic' => 'required|string|size:10|unique:postmen,nic',
            'mobile' => 'required|string|max:15',
            'paysheet_id' => 'nullable|string|max:255',
            'postman_type' => 'required|in:permanent,temporary,substitute',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            $postman = Postman::create([
                'name' => $validated['name'],
                'nic' => $validated['nic'],
                'mobile' => $validated['mobile'],
                'paysheet_id' => $validated['paysheet_id'],
                'location_id' => $user->location_id,
                'created_by' => $user->id,
                'postman_type' => $validated['postman_type'],
                'status' => $validated['status'],
            ]);

            DB::commit();

            return redirect()->route('pm.postmen.index')
                           ->with('success', 'Postman created successfully!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create postman. Please try again.');
        }
    }

    /**
     * Display the specified postman.
     */
    public function show(string $id)
    {
        $user = Auth::guard('pm')->user();

        if (!$user) {
            return redirect()->route('pm.login')->with('error', 'Please login to access this page.');
        }

        $postman = Postman::forLocation($user->location_id)
                          ->with(['location', 'creator', 'updater'])
                          ->findOrFail($id);

        return view('pm.postmen.show', compact('postman'));
    }

    /**
     * Show the form for editing the specified postman.
     */
    public function edit(string $id)
    {
        $user = Auth::guard('pm')->user();

        if (!$user) {
            return redirect()->route('pm.login')->with('error', 'Please login to access this page.');
        }

        $postman = Postman::forLocation($user->location_id)->findOrFail($id);

        return view('pm.postmen.edit', compact('postman'));
    }

    /**
     * Update the specified postman in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::guard('pm')->user();

        if (!$user) {
            return redirect()->route('pm.login')->with('error', 'Please login to access this page.');
        }

        $postman = Postman::forLocation($user->location_id)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nic' => 'required|string|size:10|unique:postmen,nic,' . $postman->id,
            'mobile' => 'required|string|max:15',
            'paysheet_id' => 'nullable|string|max:255',
            'postman_type' => 'required|in:permanent,temporary,substitute',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            $postman->update([
                'name' => $validated['name'],
                'nic' => $validated['nic'],
                'mobile' => $validated['mobile'],
                'paysheet_id' => $validated['paysheet_id'],
                'postman_type' => $validated['postman_type'],
                'status' => $validated['status'],
                'updated_by' => $user->id,
            ]);

            DB::commit();

            return redirect()->route('pm.postmen.index')
                           ->with('success', 'Postman updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update postman. Please try again.');
        }
    }

    /**
     * Remove the specified postman from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::guard('pm')->user();

        if (!$user) {
            return redirect()->route('pm.login')->with('error', 'Please login to access this page.');
        }

        $postman = Postman::forLocation($user->location_id)->findOrFail($id);

        try {
            $postman->delete();

            return redirect()->route('pm.postmen.index')
                           ->with('success', 'Postman deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to delete postman. Please try again.');
        }
    }

    /**
     * Toggle the status of a postman.
     */
    public function toggleStatus(string $id)
    {
        $user = Auth::guard('pm')->user();

        if (!$user) {
            return redirect()->route('pm.login')->with('error', 'Please login to access this page.');
        }

        $postman = Postman::forLocation($user->location_id)->findOrFail($id);

        try {
            $postman->update([
                'status' => $postman->status === 'active' ? 'inactive' : 'active',
                'updated_by' => $user->id,
            ]);

            $status = $postman->status === 'active' ? 'activated' : 'deactivated';

            return redirect()->back()
                           ->with('success', "Postman {$status} successfully!");

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to update postman status. Please try again.');
        }
    }
}
