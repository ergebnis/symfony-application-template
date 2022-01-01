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
        'dbal' => [
            'connections' => [
                'default' => [
                    'charset' => 'utf8',
                    'default_table_options' => [
                        'charset' => 'utf8mb4',
                        'collate' => 'utf8mb4_unicode_ci',
                    ],
                    'driver' => 'pdo_pgsql',
                    'server_version' => '12',
                    'url' => '%env(resolve:DATABASE_URL)%',
                ],
            ],
            'default_connection' => 'default',
        ],
        'orm' => [
            'auto_generate_proxy_classes' => true,
            'default_entity_manager' => 'default',
            'entity_managers' => [
                'default' => [
                    'auto_mapping' => false,
                    'connection' => 'default',
                    'mappings' => [
                        'app' => [
                            'alias' => 'App',
                            'dir' => '%kernel.project_dir%/src/Entity',
                            'is_bundle' => false,
                            'prefix' => 'App\Entity',
                            'type' => 'annotation',
                        ],
                    ],
                    'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
                ],
            ],
        ],
    ]);
};
