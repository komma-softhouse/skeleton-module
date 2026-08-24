<?php

declare(strict_types=1);

namespace Komma\SkeletonPlugin;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SkeletonPluginServiceProvider extends PackageServiceProvider
{
    /**
     * Registered with Filament through this name. Keep it in sync with
     * SkeletonPlugin::getId() and the config file name.
     */
    public static string $name = 'skeleton-plugin';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations();

        // Migrations: uncomment and list them when the plugin ships tables.
        // ->hasMigrations(['create_skeleton_plugin_table'])
        // ->runsMigrations()

        // Commands: uncomment when the plugin ships artisan commands.
        // ->hasCommands([Commands\SkeletonPluginCommand::class])
    }

    public function packageBooted(): void
    {
        /**
         * Register assets ONLY when they are loaded on demand (async Alpine
         * components, lazy CSS). Assets that must load on every page of a
         * panel belong in SkeletonPlugin::register() via $panel->assets(),
         * otherwise they leak into every panel of the host app.
         *
         * @see https://filamentphp.com/docs/5.x/plugins/getting-started
         * @see https://filamentphp.com/docs/5.x/advanced/assets
         */
        // FilamentAsset::register(
        //     assets: [
        //         AlpineComponent::make('skeleton-plugin', __DIR__ . '/../resources/dist/skeleton-plugin.js'),
        //     ],
        //     package: 'komma-softhouse/skeleton-plugin',
        // );
    }
}
