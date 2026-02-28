<?php

declare(strict_types=1);

it('keeps provider contract for loading and publishing filament preview view', function (): void {
    $root = dirname(__DIR__, 2);
    $provider = file_get_contents($root . '/src/CampaignKitFilamentServiceProvider.php');

    expect($provider)->toContain("loadViewsFrom(__DIR__ . '/../resources/views', 'campaign-kit-filament')");
    expect($provider)->toContain('campaign-kit-filament-views');
    expect($provider)->toContain("resource_path('views/filament/forms/campaign-type-preview.blade.php')");
});
