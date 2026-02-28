<?php

declare(strict_types=1);

it('keeps the expected campaign preview ui contract for filament integration', function (): void {
    $root = dirname(__DIR__, 2);
    $view = file_get_contents($root . '/resources/views/filament/forms/campaign-type-preview.blade.php');

    expect($view)->toContain("route('campaign.layout-preview'");
    expect($view)->toContain('電腦預覽');
    expect($view)->toContain('手機預覽');
    expect($view)->toContain('previewRouteTemplate');
    expect($view)->toContain('campaign/layouts/placeholder.webp');
    expect($view)->toContain('即時預覽失敗，改用靜態圖片顯示。');
});
