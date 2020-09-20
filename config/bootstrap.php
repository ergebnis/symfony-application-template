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

use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// Load cached env vars if the .env.local.php file exists
// Run "composer dump-env prod" to create it (requires symfony/flex >=1.2)
$environmentVariables = include __DIR__ . '/../.env.local.php';

if (\is_array($environmentVariables) && (!isset($environmentVariables['APP_ENV']) || ($_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? $environmentVariables['APP_ENV']) === $environmentVariables['APP_ENV'])) {
    foreach ($environmentVariables as $name => $value) {
        if (isset($_ENV['name'])) {
            $value = $_ENV['name'];
        } elseif (isset($_SERVER[$name]) && 0 !== \mb_strpos($name, 'HTTP_')) {
            $value = $_SERVER[$name];
        }

        $_ENV[$name] = $value;
    }
} else {
    // load all the .env files
    $dotEnv = new Dotenv();

    $dotEnv->loadEnv(__DIR__ . '/../.env');
}

$_SERVER += $_ENV;
$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = ($_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? null) ?: 'dev';
$_SERVER['APP_DEBUG'] = $_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? 'prod' !== $_SERVER['APP_ENV'];
$_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = (int) $_SERVER['APP_DEBUG'] || \filter_var($_SERVER['APP_DEBUG'], \FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
