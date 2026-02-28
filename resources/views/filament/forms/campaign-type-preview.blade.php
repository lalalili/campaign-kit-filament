@php
    $previewConfig = (array) data_get(config('campaign-kit', []), 'preview.types', []);
    $valueToSlug = [];

    foreach ($previewConfig as $typeValue => $typeConfig) {
        if (! is_array($typeConfig)) {
            continue;
        }

        $slug = (string) ($typeConfig['slug'] ?? $typeValue);
        $valueToSlug[(int) $typeValue] = $slug;
    }

    $base = asset('campaign/layouts');
    $fallback = asset('campaign/layouts/placeholder.webp');
    $previewRouteTemplate = route('campaign.layout-preview', ['type' => '__TYPE__', 'variant' => '__VARIANT__']);
@endphp

<div
    x-data="{
        type: $wire.$entangle('data.type'),
        slugMap: @js($valueToSlug),
        variant: 'desktop',
        base: @js($base),
        fallback: @js($fallback),
        previewRouteTemplate: @js($previewRouteTemplate),
        iframeFailed: false,
        previewUrl() {
            if (! this.type) {
                return '';
            }

            return this.previewRouteTemplate
                .replace('__TYPE__', String(this.type))
                .replace('__VARIANT__', this.variant);
        }
    }"
    class="mt-2"
>
    <div class="mb-3 flex gap-2">
        <button
            type="button"
            class="rounded-lg border px-3 py-1 text-sm font-medium transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-500"
            :class="variant === 'desktop'
                ? 'border-primary-600 bg-primary-600 text-white dark:border-primary-500 dark:bg-primary-500'
                : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800'"
            :aria-pressed="variant === 'desktop'"
            @click="variant = 'desktop'"
        >
            Desktop Preview
        </button>

        <button
            type="button"
            class="rounded-lg border px-3 py-1 text-sm font-medium transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-500"
            :class="variant === 'mobile'
                ? 'border-primary-600 bg-primary-600 text-white dark:border-primary-500 dark:bg-primary-500'
                : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800'"
            :aria-pressed="variant === 'mobile'"
            @click="variant = 'mobile'"
        >
            Mobile Preview
        </button>
    </div>

    <template x-if="type && slugMap[type]">
        <div class="space-y-3">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <p class="text-xs text-gray-600 dark:text-gray-300">
                    Live preview is rendered from layout skeleton data.
                </p>
                <a
                    x-show="previewUrl()"
                    :href="previewUrl()"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800"
                >
                    Open Preview
                </a>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-900">
                <iframe
                    class="h-[420px] w-full bg-white dark:bg-gray-900"
                    :src="previewUrl()"
                    title="Campaign layout live preview"
                    loading="lazy"
                    x-on:load="iframeFailed = false"
                    x-on:error="iframeFailed = true"
                ></iframe>
            </div>

            <div x-show="iframeFailed" class="rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-xs text-amber-900 dark:border-amber-500/40 dark:bg-amber-500/10 dark:text-amber-200">
                Live preview failed. Falling back to static image.
            </div>

            <img
                x-show="iframeFailed"
                class="mx-auto block h-56 w-auto max-w-full rounded-xl border border-gray-300 object-contain md:h-80 dark:border-gray-600"
                loading="lazy"
                decoding="async"
                :src="`${base}/${slugMap[type]}${variant === 'mobile' ? '-mobile' : ''}.webp`"
                :alt="`${slugMap[type]} fallback preview`"
                x-on:error="
                    $event.target.onerror = null;
                    $event.target.src = fallback;
                "
            >
            <div class="mt-2 text-xs text-gray-600 dark:text-gray-300"
                 x-text="`Static image: ${slugMap[type]}${variant === 'mobile' ? '-mobile' : ''}.webp`"></div>
        </div>
    </template>

    <div x-show="!type || !slugMap[type]" class="text-sm text-gray-600 dark:text-gray-300">
        Please choose a layout type.
    </div>
</div>
