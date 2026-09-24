<?php

namespace RicardoSnery\NLoading;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\View\PanelsRenderHook;

class NLoadingPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'nloading';
    }

    public function register(Panel $panel): void
    {
        $panel->assets([
            Css::make('nloading', __DIR__.'/../resources/css/nloading.css'),
            Js::make('nloading', __DIR__.'/../resources/js/nloading.js'),
        ], package: 'ricardosnery/nloading');

        $panel->renderHook(
            PanelsRenderHook::BODY_START,
            fn (): string => view('nloading::overlay')->render(),
        );
    }

    public function boot(Panel $panel): void {}
}
