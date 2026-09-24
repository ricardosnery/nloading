# NLoading for Filament

Configurable loading overlay for Filament v5 page navigation and selected Livewire updates.

NLoading is free and open source under the MIT License. See [LICENSE](LICENSE).

## Requirements

- PHP 8.2+
- Laravel 12+
- Filament 5+

## Installation

```bash
composer require ricardosnery/nloading
```

Register the plugin on each panel where the overlay should appear:

```php
use RicardoSnery\NLoading\NLoadingPlugin;

return $panel
    ->plugin(NLoadingPlugin::make());
```

Filament publishes the plugin's CSS and JavaScript assets during its asset upgrade process. If needed, publish them manually:

```bash
php artisan filament:assets
```

Publish the configuration and views only if you need to edit them:

```bash
php artisan vendor:publish --tag=nloading-config
php artisan vendor:publish --tag=nloading-views
```

## Configuration

Edit `config/nloading.php`:

```php
return [
    'enabled' => true,
    'position' => 'center', // top, center, bottom, top-left, bottom-left, top-right, bottom-right
    'logo' => null, // Public URL/path; null uses the Filament panel logo
    'spinner' => null, // Public image URL/path; null uses the built-in CSS indicator
    'spinner_animation' => true,
    'indicator_position' => 'after', // before or after the message
    'message' => null,
    'delay' => 150,
    'overlay' => [
        'color' => '#0f172a',
        'opacity' => 0.35, // 0 to 1
    ],
    'navigation' => ['enabled' => true],
    'livewire' => [
        'enabled' => true,
        'ignore_polling' => true,
        'exclude_actions' => [],
    ],
];
```

Navigation and Livewire commits can be enabled independently. Livewire actions listed in `exclude_actions` are ignored. Polling components are ignored by default; set `livewire.ignore_polling` to `false` to include them. Concurrent Livewire requests are counted, and requests completed before the configured delay do not show the overlay.

Every option can also be set with an environment variable prefixed by `NLOADING_`:

| Environment variable | Config key | Default |
| --- | --- | --- |
| `NLOADING_ENABLED` | `enabled` | `true` |
| `NLOADING_POSITION` | `position` | `center` |
| `NLOADING_LOGO` | `logo` | empty; uses the Filament logo |
| `NLOADING_SPINNER` | `spinner` | empty; uses the CSS indicator |
| `NLOADING_SPINNER_ANIMATION` | `spinner_animation` | `true` |
| `NLOADING_INDICATOR_POSITION` | `indicator_position` | `after` |
| `NLOADING_MESSAGE` | `message` | empty |
| `NLOADING_DELAY` | `delay` | `150` ms |
| `NLOADING_OVERLAY_COLOR` | `overlay.color` | `#0f172a` |
| `NLOADING_OVERLAY_OPACITY` | `overlay.opacity` | `0.35` |
| `NLOADING_NAVIGATION_ENABLED` | `navigation.enabled` | `true` |
| `NLOADING_LIVEWIRE_ENABLED` | `livewire.enabled` | `true` |
| `NLOADING_LIVEWIRE_IGNORE_POLLING` | `livewire.ignore_polling` | `true` |
| `NLOADING_LIVEWIRE_EXCLUDE_ACTIONS` | `livewire.exclude_actions` | empty |

`NLOADING_LIVEWIRE_EXCLUDE_ACTIONS` accepts comma-separated action names, for example `NLOADING_LIVEWIRE_EXCLUDE_ACTIONS=refreshStats,updateClock`.

The overlay view can be customized by publishing the views. The published file at `resources/views/vendor/nloading/overlay.blade.php` takes precedence over the package view. The indicator partial can also be overridden at `resources/views/vendor/nloading/partials/indicator.blade.php`.

## License

NLoading is open source software licensed under the [MIT License](LICENSE).

## Support and contributions

Please use the [GitHub issue tracker](https://github.com/ricardosnery/nloading/issues) to report bugs or suggest improvements. Contributions are welcome.
