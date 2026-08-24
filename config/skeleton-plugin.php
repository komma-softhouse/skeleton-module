<?php

declare(strict_types=1);

return [

    /*
     * Every infrastructure-dependent surface ships disabled. Hosts opt in
     * here or through the fluent plugin API in their panel provider.
     */
    'example_feature' => env('SKELETON_PLUGIN_EXAMPLE_FEATURE', false),

];
