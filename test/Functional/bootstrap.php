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

use Symfony\Component\Dotenv;

require \dirname(__DIR__, 2) . '/vendor/autoload.php';

if (\file_exists(\dirname(__DIR__, 2) . '/config/bootstrap.php')) {
    require \dirname(__DIR__, 2) . '/config/bootstrap.php';
} else {
    (new Dotenv\Dotenv())->bootEnv(\dirname(__DIR__, 2) . '/.env');
}
