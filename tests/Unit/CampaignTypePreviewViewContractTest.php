<?php

declare(strict_types=1);

it('keeps the expected campaign preview ui contract for filament integration', function (): void {
    $root = dirname(__DIR__, 2);
    $view = file_get_contents($root . '/resources/views/filament/forms/campaign-type-preview.blade.php');

    expect($view)->toContain("route('campaign.layout-preview'");
    expect($view)->toContain('Desktop Preview');
    expect($view)->toContain('Mobile Preview');
    expect($view)->toContain('previewRouteTemplate');
    expect($view)->toContain('campaign/layouts/placeholder.webp');
    expect($view)->toContain('Live preview failed. Falling back to static image.');
});
