<?php

declare(strict_types=1);

namespace Komma\SkeletonPlugin;

use Filament\Contracts\Plugin;
use Filament\Panel;

/**
 * Panel plugin entry point. Host apps register it in their panel provider:
 *
 *     $panel->plugin(SkeletonPlugin::make()->exampleFeature());
 *
 * @see https://filamentphp.com/docs/5.x/plugins/panel-plugins
 */
class SkeletonPlugin implements Plugin
{
    /**
     * Feature toggles are ALWAYS off by default (Komma standard): a host
     * that enables nothing gets zero extra dependencies and zero surprises.
     */
    protected bool $hasExampleFeature = false;

    public static function make(): static
    {
        // Resolved through the container so hosts can swap the implementation.
        return app(static::class);
    }

    public static function get(): static
    {
        // Typed access to the configured instance from anywhere in the code:
        // SkeletonPlugin::get()->hasExampleFeature()
        return filament(app(static::class)->getId());
    }

    public function getId(): string
    {
        return 'skeleton-plugin';
    }

    /** Setter + getter pair per option — the Filament fluent standard. */
    public function exampleFeature(bool $condition = true): static
    {
        $this->hasExampleFeature = $condition;

        return $this;
    }

    public function hasExampleFeature(): bool
    {
        return $this->hasExampleFeature;
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                // Resources\ExampleResource::class,

                // v5 configurable registrations (N registrations, one class):
                // Resources\ExampleResource::make('active')->navigationLabel(__('Active')),
                // @see https://filamentphp.com/docs/5.x/plugins/configurable-resources-and-pages
            ])
            ->pages([
                // Pages\SkeletonPluginSettings::class,
            ])
            ->widgets([
                // Widgets\SkeletonPluginStats::class,
            ]);

        if ($this->hasExampleFeature()) {
            // Conditional registrations live here, driven by the toggles above.
        }
    }

    public function boot(Panel $panel): void
    {
        // Runs only when the panel this plugin is registered to is in use.
    }
}
