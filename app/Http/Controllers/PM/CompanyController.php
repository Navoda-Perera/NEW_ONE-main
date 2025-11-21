<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
     */
    public function index(Request $request)
    {
        $query = Company::with(['assignedPostoffice', 'creator']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('telephone', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%")
                  ->orWhereHas('creator', function ($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('assignedPostoffice', function ($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $companies = $query->orderBy('created_at', 'desc')->paginate(10);

        // Append query parameters to pagination links
        $companies->appends($request->query());

        return view('pm.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new company.
     */
    public function create()
    {
        $postoffices = Location::all();
        return view('pm.companies.create', compact('postoffices'));
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'address' => 'required|string',
            'email' => 'nullable|email|max:255',
            'type' => 'required|in:cash,credit,franking,prepaid',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'assign_postoffice' => 'required|exists:locations,id',
        ];

        // Add balance validation only for prepaid companies
        if ($request->type === 'prepaid') {
            $rules['balance'] = 'required|numeric|min:0.01';
        }

        $request->validate($rules);

        try {
            DB::beginTransaction();

            // Get the current authenticated PM user
            $currentPmUser = Auth::guard('pm')->user();
            $pmUserId = $currentPmUser ? $currentPmUser->id : null;

            // Fallback to regular auth if PM auth is not available
            if (!$pmUserId) {
                $currentUser = Auth::user();
                $pmUserId = $currentUser ? $currentUser->id : 1; // Fallback to admin
            }

            // Set balance based on company type
            $balance = 0;
            if ($request->type === 'prepaid') {
                $balance = $request->balance ?? 0;
            }

            $company = Company::create([
                'name' => $request->name,
                'telephone' => $request->telephone,
                'address' => $request->address,
                'email' => $request->email,
                'type' => $request->type,
                'status' => $request->status,
                'assign_postoffice' => $request->assign_postoffice,
                'balance' => $balance,
                'created_by' => $pmUserId,
            ]);

            // If initial balance is provided for prepaid companies, create a deposit record
            if ($request->type === 'prepaid' && $balance > 0) {
                $company->addBalance($balance);
                // Reset balance since addBalance increments it
                $company->update(['balance' => $balance]);
            }

            DB::commit();

            return redirect()
                ->route('pm.companies.index')
                ->with('success', 'Company created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create company: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified company.
     */
    public function show(Company $company)
    {
        $company->load(['assignedPostoffice', 'creator', 'deposits', 'withdraws']);
        return view('pm.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Company $company)
    {
        $postoffices = Location::all();
        return view('pm.companies.edit', compact('company', 'postoffices'));
    }

    /**
     * Update the specified company in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'address' => 'required|string',
            'email' => 'nullable|email|max:255',
            'type' => 'required|in:cash,credit,franking,prepaid',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'assign_postoffice' => 'required|exists:locations,id',
        ]);

        try {
            $company->update([
                'name' => $request->name,
                'telephone' => $request->telephone,
                'address' => $request->address,
                'email' => $request->email,
                'type' => $request->type,
                'status' => $request->status,
                'assign_postoffice' => $request->assign_postoffice,
            ]);

            return redirect()
                ->route('pm.companies.index')
                ->with('success', 'Company updated successfully!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update company: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified company from storage.
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();
            return redirect()
                ->route('pm.companies.index')
                ->with('success', 'Company deleted successfully!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to delete company: ' . $e->getMessage()]);
        }
    }

    /**
     * Add balance to company
     */
    public function addBalance(Request $request, Company $company)
    {
        // Check if company is prepaid type
        if ($company->type !== 'prepaid') {
            return back()->withErrors(['error' => 'Balance management is only available for prepaid companies.']);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        try {
            $company->addBalance($request->amount);

            return back()->with('success', 'Balance added successfully! New balance: LKR ' . number_format($company->fresh()->balance, 2));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to add balance: ' . $e->getMessage()]);
        }
    }

    /**
     * Deduct balance from company
     */
    public function deductBalance(Request $request, Company $company)
    {
        // Check if company is prepaid type
        if ($company->type !== 'prepaid') {
            return back()->withErrors(['error' => 'Balance management is only available for prepaid companies.']);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $company->balance
        ], [
            'amount.max' => 'Amount cannot exceed available balance of LKR ' . number_format($company->balance, 2)
        ]);

        try {
            $company->deductBalance($request->amount);

            return back()->with('success', 'Balance deducted successfully! New balance: LKR ' . number_format($company->fresh()->balance, 2));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
