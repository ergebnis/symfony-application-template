<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2024 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/symfony-application-template
 */

use Symfony\Component\Routing;

return static function (Routing\Loader\Configurator\RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import('../../src/Controller/', 'attribute');
    $routingConfigurator->import('../../src/Kernel.php', 'attribute');
};
