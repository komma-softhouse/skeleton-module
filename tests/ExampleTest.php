<?php

declare(strict_types=1);

use Komma\SkeletonPlugin\SkeletonPlugin;

it('exposes its plugin id', function () {
    expect(SkeletonPlugin::make()->getId())->toBe('skeleton-plugin');
});

it('keeps feature toggles off by default', function () {
    expect(SkeletonPlugin::make()->hasExampleFeature())->toBeFalse();
});

it('enables features fluently', function () {
    expect(SkeletonPlugin::make()->exampleFeature()->hasExampleFeature())->toBeTrue();
});
