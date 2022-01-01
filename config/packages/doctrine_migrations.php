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
    $containerConfigurator->extension('doctrine_migrations', [
        'custom_template' => '%kernel.project_dir%/migrations/migration.tpl',
        'migrations_paths' => [
            'App\Migration' => '%kernel.project_dir%/migrations',
        ],
    ]);
};
