<?php

namespace App\Providers;

use App\Support\SiteModules;
use App\Support\SiteSettings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SiteModules::class, function ($app) {
            return new SiteModules($app->make(SiteSettings::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            $settings = app(SiteSettings::class);
            $modules = app(SiteModules::class);

            $view->with('socialLinks', $settings->socialLinks());
            $view->with('footerSettings', $settings->footer());
            $view->with('homePopup', $settings->homePopupForPublic());
            $view->with('moduleEnabled', fn (string $id): bool => $modules->enabled($id));
        });
    }
}
