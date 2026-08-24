# Skeleton Plugin

🚀 Skeleton template for building Filament 5.x plugins | Komma SoftHouse plugin standard

This repository replaces the old `skeleton-module` (Laravel Modules) template for everything that ships as a **redistributable Filament plugin**. Internal app modules keep their own standard; anything installed via Composer into third-party Laravel apps starts here.

Built on the official Filament 5.x plugin guidelines:

- [Getting started](https://filamentphp.com/docs/5.x/plugins/getting-started)
- [Panel plugins](https://filamentphp.com/docs/5.x/plugins/panel-plugins)
- [Building a panel plugin](https://filamentphp.com/docs/5.x/plugins/building-a-panel-plugin)
- [Building a standalone plugin](https://filamentphp.com/docs/5.x/plugins/building-a-standalone-plugin)
- [Configurable resources and pages](https://filamentphp.com/docs/5.x/plugins/configurable-resources-and-pages)

## Requirements

- PHP >= 8.4
- Laravel >= 13.0
- Filament >= 5.0

## Creating a new plugin

1. On GitHub, click **Use this template** to create the new plugin repository.
2. Clone it and run the configurator:

```bash
php ./configure.php
```

Answer the prompts (plugin name, vendor, namespace, description). The script rewrites the package name, namespaces, class names and file names, optionally resets git history, and removes itself — the same workflow as the official Filament plugin skeleton.

3. Install and verify:

```bash
composer install
composer test
```

4. Read [`docs/how-to-build-a-filament-plugin.md`](docs/how-to-build-a-filament-plugin.md) — the Komma plugin standard — and start building.

## Using a plugin built from this skeleton

Register it in the host panel provider:

```php
use Komma\SkeletonPlugin\SkeletonPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(
            SkeletonPlugin::make()
                ->exampleFeature(),
        );
}
```

Every feature toggle ships **disabled by default**: a host that enables nothing gets zero extra dependencies.

## What's inside

| Path                                     | Purpose                                                                                |
| ---------------------------------------- | -------------------------------------------------------------------------------------- |
| `src/SkeletonPlugin.php`                 | Panel plugin object (`getId` / `register` / `boot`, `make()`, `get()`, fluent toggles) |
| `src/SkeletonPluginServiceProvider.php`  | `PackageServiceProvider` (spatie/laravel-package-tools) with asset registration notes  |
| `config/skeleton-plugin.php`             | Publishable config — toggles off by default                                            |
| `resources/lang/*.json`                  | JSON translations keyed by English literals (`__('English literal')`)                  |
| `tests/`                                 | Pest + Testbench with the full Filament 5 provider set                                 |
| `.github/workflows/tests.yml`            | CI: Pint (style) + Pest on PHP 8.4                                                     |
| `docs/how-to-build-a-filament-plugin.md` | The Komma ecosystem plugin standard                                                    |

## Testing

```bash
composer test
```

## Credits

- [Elias Olivtradet](https://github.com/edeoliv)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
