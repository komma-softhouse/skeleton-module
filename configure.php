#!/usr/bin/env php
<?php

/**
 * Komma SoftHouse plugin skeleton configurator.
 *
 * Usage: clone the template repo, then run `php ./configure.php` and answer
 * the prompts. The script rewrites namespaces, package name, class names and
 * file names, then removes itself. Mirrors the official Filament plugin
 * skeleton workflow (https://filamentphp.com/docs/5.x/plugins/getting-started).
 */

declare(strict_types=1);

function ask(string $question, string $default = ''): string
{
    $suffix = $default !== '' ? " [{$default}]" : '';
    $answer = readline("{$question}{$suffix}: ");

    return trim($answer !== '' && $answer !== false ? $answer : $default);
}

function confirm(string $question, bool $default = true): bool
{
    $suffix = $default ? ' [Y/n]' : ' [y/N]';
    $answer = strtolower(trim((string) readline($question . $suffix . ': ')));

    if ($answer === '') {
        return $default;
    }

    return in_array($answer, ['y', 'yes'], true);
}

function studly(string $value): string
{
    return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value)));
}

function kebab(string $value): string
{
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', studly($value)));
}

$pluginName = ask('Plugin name (e.g. "Verifactu")');

if ($pluginName === '') {
    fwrite(STDERR, "A plugin name is required.\n");
    exit(1);
}

$vendorSlug = ask('Vendor (composer)', 'komma-softhouse');
$vendorNamespace = ask('Vendor namespace', 'Komma');
$description = ask('Description', "A Filament 5.x plugin by Komma SoftHouse");

$studlyName = studly($pluginName);
$kebabName = kebab($pluginName);

$replacements = [
    // Longest / most specific first, so partial tokens never collide.
    'komma-softhouse/skeleton-plugin' => "{$vendorSlug}/filament-{$kebabName}",
    'Komma\\SkeletonPlugin' => "{$vendorNamespace}\\{$studlyName}",
    'Komma\\\\SkeletonPlugin' => "{$vendorNamespace}\\\\{$studlyName}",
    'SkeletonPlugin' => "{$studlyName}Plugin",
    'skeleton-plugin' => "filament-{$kebabName}",
    'SKELETON_PLUGIN' => strtoupper(str_replace('-', '_', $kebabName)),
    '🚀 Skeleton template for building Filament 5.x plugins | Komma SoftHouse plugin standard' => $description,
];

$directory = new RecursiveIteratorIterator(
    new RecursiveCallbackFilterIterator(
        new RecursiveDirectoryIterator(__DIR__, FilesystemIterator::SKIP_DOTS),
        fn (SplFileInfo $current): bool => ! in_array($current->getFilename(), ['.git', 'vendor', 'node_modules'], true),
    ),
);

$files = [];

foreach ($directory as $file) {
    if ($file->isFile() && $file->getRealPath() !== __FILE__) {
        $files[] = $file->getRealPath();
    }
}

foreach ($files as $path) {
    $contents = file_get_contents($path);
    $updated = str_replace(array_keys($replacements), array_values($replacements), $contents);

    if ($updated !== $contents) {
        file_put_contents($path, $updated);
    }

    $newPath = str_replace('SkeletonPlugin', "{$studlyName}Plugin", basename($path));

    if ($newPath !== basename($path)) {
        rename($path, dirname($path) . DIRECTORY_SEPARATOR . $newPath);
    }
}

// Rename config and lang artifacts that carry the kebab name.
$configFile = __DIR__ . '/config/skeleton-plugin.php';

if (file_exists($configFile)) {
    rename($configFile, __DIR__ . "/config/filament-{$kebabName}.php");
}

if (confirm('Reset git history (rm -rf .git && git init)?')) {
    exec('rm -rf ' . escapeshellarg(__DIR__ . '/.git'));
    exec('git -C ' . escapeshellarg(__DIR__) . ' init --quiet');
}

echo "\nPlugin \"{$vendorSlug}/filament-{$kebabName}\" configured. Next steps:\n";
echo "  1. composer install\n";
echo "  2. composer test\n";
echo "  3. Read docs/how-to-build-a-filament-plugin.md and start building.\n";

unlink(__FILE__);
