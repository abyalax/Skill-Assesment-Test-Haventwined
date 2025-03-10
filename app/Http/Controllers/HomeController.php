<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Events;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class HomeController extends Controller {
    public function index() {
        $events = Events::all();
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'events' => $events
        ]);
    }
}
