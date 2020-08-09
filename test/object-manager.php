<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/symfony-application-template
 */

use Ergebnis\Application;

require __DIR__ . '/../config/bootstrap.php';

$kernel = new Application\Kernel(
    $_SERVER['APP_ENV'],
    (bool) $_SERVER['APP_DEBUG']
);

$kernel->boot();

return $kernel->getContainer()->get('doctrine')->getManager();
