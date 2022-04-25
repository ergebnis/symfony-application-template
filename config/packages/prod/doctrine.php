<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2022 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/symfony-application-template
 */

use Symfony\Component\DependencyInjection;

return static function (DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('doctrine', [
        'orm' => [
            'auto_generate_proxy_classes' => false,
            'metadata_cache_driver' => [
                'pool' => 'doctrine.system_cache_pool',
                'type' => 'pool',
            ],
            'query_cache_driver' => [
                'pool' => 'doctrine.system_cache_pool',
                'type' => 'pool',
            ],
            'result_cache_driver' => [
                'pool' => 'doctrine.result_cache_pool',
                'type' => 'pool',
            ],
        ],
    ]);
};
