<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyProfileUpdateRequest;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class CompanyProfileController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $user = Auth::user();
        $company = CompanyProfile::where('selected', true)->get()
            ->tap(fn($collection) => $collection->each(
                fn($company) =>
                $company->banner = json_decode($company->banner, true)
            ));
        return Inertia::render('Dashboard/Index', [
            'nama' => $user->name,
            'company' => $company,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return Inertia::render('Dashboard/Company/Update');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyProfile $companyProfile) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyProfile $company_profile) {
        $user = Auth::user();
        return Inertia::render('Dashboard/Company/Update', [
            'nama' => $user->name,
            'company' => $company_profile,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyProfileUpdateRequest $request, CompanyProfile $companyProfile): RedirectResponse {
        // Filter hanya field yang dikirim
        $data = array_filter($request->only(['name', 'description', 'email', 'whatsapp', 'banner']), function ($value) {
            return $value !== null;
        });
        Log::debug("Data request :", $data);
        try {
            $updated = $companyProfile->update($data);
            if ($updated) {
                return Redirect::route('dashboard')->with('success', 'Company profile updated successfully.');
            } else {
                return Redirect::back()->with('error', 'Failed to update company profile.');
            }
        } catch (\Exception $e) {
            Log::error("Gagal update data: " . $e->getMessage());
            return Redirect::back()->with('error', 'Failed to update company profile.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyProfile $companyProfile) {
        //
    }
}
