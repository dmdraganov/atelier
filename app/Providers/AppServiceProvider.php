<?php

namespace App\Providers;

use App\Models\TailoringService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.layouts.app', function ($view): void {
            $view->with('footerServices', TailoringService::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->limit(4)
                ->get());
        });
    }
}
