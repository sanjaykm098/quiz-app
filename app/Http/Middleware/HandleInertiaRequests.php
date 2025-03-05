<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'user' => fn() => $request->user()
                ? $request->user()->only('id', 'name', 'email')
                : null,
            'profile_routes' => [
                'dashboard' => route('user.dashboard'),
                'all_results' => route('all.results'),
                'logout' => route('logout'),
            ],
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
            'baseUrl' => url('/'),
            'backUrl' => url()->previous(),
            'currentUrl' => url()->current(),
            'homeUrl' => route('user.dashboard'),
            'isBackUrl' => url()->previous() !== url()->current()
                && url()->previous() !== url()->full()
                && url()->previous() !== route('user.dashboard'),
        ]);
    }
}
