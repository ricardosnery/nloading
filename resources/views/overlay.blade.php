@php
    $configuration = [
        'enabled' => (bool) config('nloading.enabled', true),
        'delay' => max(0, (int) config('nloading.delay', 150)),
        'navigation' => (bool) config('nloading.navigation.enabled', true),
        'livewire' => [
            'enabled' => (bool) config('nloading.livewire.enabled', true),
            'ignorePolling' => (bool) config('nloading.livewire.ignore_polling', true),
            'excludeActions' => array_values(config('nloading.livewire.exclude_actions', [])),
        ],
    ];
    $position = config('nloading.position', 'center');
    $validPositions = ['top', 'center', 'bottom', 'top-left', 'bottom-left', 'top-right', 'bottom-right'];
    $position = in_array($position, $validPositions, true) ? $position : 'center';
    $overlayColor = config('nloading.overlay.color', '#0f172a');
    if (! is_string($overlayColor) || preg_match('/^#(?:[a-fA-F0-9]{3}|[a-fA-F0-9]{6})$/', $overlayColor) !== 1) {
        $overlayColor = '#0f172a';
    }
    $overlayOpacity = min(1, max(0, (float) config('nloading.overlay.opacity', 0.35)));
    $logo = config('nloading.logo');
    $spinner = config('nloading.spinner');
    $spinnerAnimation = (bool) config('nloading.spinner_animation', true);
    $indicatorPosition = config('nloading.indicator_position', 'after');
    $indicatorPosition = in_array($indicatorPosition, ['before', 'after'], true) ? $indicatorPosition : 'after';
    $message = config('nloading.message');
@endphp

<div
    id="nloading-overlay"
    x-persist="nloading-overlay"
    class="nloading-overlay nloading-overlay--{{ $position }}"
    aria-live="polite"
    aria-atomic="true"
    aria-hidden="true"
    data-nloading-enabled="{{ $configuration['enabled'] ? 'true' : 'false' }}"
    data-nloading-config="{{ json_encode($configuration) }}"
    data-spinner-animation="{{ $spinnerAnimation ? 'true' : 'false' }}"
    style="--nloading-overlay-color: {{ $overlayColor }}; --nloading-overlay-opacity: {{ $overlayOpacity }}; display: none"
>
    <div class="nloading-overlay__content" role="status">
        @if (filled($logo))
            <img class="nloading-overlay__logo" src="{{ $logo }}" alt="" />
        @else
            <x-filament-panels::logo class="nloading-overlay__logo" />
        @endif
        <div class="nloading-overlay__status">
            @if ($indicatorPosition === 'before')
                @include('nloading::partials.indicator')
            @endif
            @if (filled($message))
                <span class="nloading-overlay__message">{{ $message }}</span>
            @else
                <span class="sr-only">{{ __('nloading::nloading.loading') }}</span>
            @endif
            @if ($indicatorPosition === 'after')
                @include('nloading::partials.indicator')
            @endif
        </div>
    </div>
</div>
