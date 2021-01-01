<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2021 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/symfony-application-template
 */

use App\Kernel;

require __DIR__ . '/../config/bootstrap.php';

$kernel = new Kernel(
    $_SERVER['APP_ENV'],
    (bool) $_SERVER['APP_DEBUG']
);

$kernel->boot();

return $kernel->getContainer()->get('doctrine')->getManager();
