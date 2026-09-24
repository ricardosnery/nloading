<?php

$excludedActions = (string) env('NLOADING_LIVEWIRE_EXCLUDE_ACTIONS', '');

return [
    'enabled' => env('NLOADING_ENABLED', true),

    'position' => env('NLOADING_POSITION', 'center'),

    'logo' => env('NLOADING_LOGO'),

    'spinner' => env('NLOADING_SPINNER'),

    'spinner_animation' => env('NLOADING_SPINNER_ANIMATION', true),

    'indicator_position' => env('NLOADING_INDICATOR_POSITION', 'after'),

    'message' => env('NLOADING_MESSAGE'),

    'delay' => (int) env('NLOADING_DELAY', 150),

    'overlay' => [
        'color' => env('NLOADING_OVERLAY_COLOR', '#0f172a'),
        'opacity' => (float) env('NLOADING_OVERLAY_OPACITY', 0.35),
    ],

    'navigation' => [
        'enabled' => env('NLOADING_NAVIGATION_ENABLED', true),
    ],

    'livewire' => [
        'enabled' => env('NLOADING_LIVEWIRE_ENABLED', true),
        'ignore_polling' => env('NLOADING_LIVEWIRE_IGNORE_POLLING', true),
        'exclude_actions' => array_values(array_filter(array_map('trim', explode(',', $excludedActions)))),
    ],
];
