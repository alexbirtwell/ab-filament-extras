<?php

namespace Alexbirtwell\AbFilamentExtras;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class AbFilamentExtrasServiceProvider extends PluginServiceProvider
{
    public static string $name = 'ab-filament-extras';

    protected array $resources = [
        // CustomResource::class,
    ];

    protected array $pages = [
        // CustomPage::class,
    ];

    protected array $widgets = [
        // CustomWidget::class,
    ];

    protected array $styles = [
        'plugin-ab-filament-extras' => __DIR__.'/../resources/dist/ab-filament-extras.css',
    ];

    protected array $scripts = [
        'plugin-ab-filament-extras' => __DIR__.'/../resources/dist/ab-filament-extras.js',
    ];

    // protected array $beforeCoreScripts = [
    //     'plugin-ab-filament-extras' => __DIR__ . '/../resources/dist/ab-filament-extras.js',
    // ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
    }

    public function boot()
    {
        $this->publishes([__DIR__ .'/../database/seeders' => database_path('seeders')], ['ab-filament-extras-seeders']);
        $this->publishes([__DIR__ .'/../database/migrations' => database_path('migrations')], ['ab-filament-extras-migrations']);
    }
}
