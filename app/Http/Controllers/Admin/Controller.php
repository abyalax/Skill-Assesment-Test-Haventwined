<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyProfile;
use Inertia\Inertia;

class Controller extends BaseController {
    public function index() {
        $user = Auth::user();
        $company = CompanyProfile::all();
        return Inertia::render('Dashboard/Index', [
            'nama' => $user->name,
            'company' => $company[0],
        ]);
    }
}
