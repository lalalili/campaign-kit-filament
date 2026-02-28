<?php

declare(strict_types=1);

namespace Lalalili\CampaignKitFilament;

use Illuminate\Support\ServiceProvider;

final class CampaignKitFilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'campaign-kit-filament');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/views/filament/forms/campaign-type-preview.blade.php' => resource_path('views/filament/forms/campaign-type-preview.blade.php'),
            ], 'campaign-kit-filament-views');
        }
    }
}
