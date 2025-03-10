<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Log;

class HandleInertiaRequests extends Middleware {
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array {
        $company = CompanyProfile::where('selected', true)->get()
            ->tap(fn($collection) => $collection->each(
                fn($company) =>
                $company->banner = json_decode($company->banner, true)
            ));
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'company_profile' => $company[0],
            'ziggy' => fn() => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
