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

use Symfony\Component\Routing;

return static function (Routing\Loader\Configurator\RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import('@FrameworkBundle/Resources/config/routing/errors.xml')->prefix('/_error');
};
