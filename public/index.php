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
use Symfony\Component\ErrorHandler;
use Symfony\Component\HttpFoundation;

require \dirname(__DIR__) . '/config/bootstrap.php';

if ($_SERVER['APP_DEBUG']) {
    \umask(0000);

    ErrorHandler\Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? $_ENV['TRUSTED_PROXIES'] ?? false) {
    HttpFoundation\Request::setTrustedProxies(
        \explode(',', $trustedProxies),
        HttpFoundation\Request::HEADER_X_FORWARDED_ALL ^ HttpFoundation\Request::HEADER_X_FORWARDED_HOST
    );
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? $_ENV['TRUSTED_HOSTS'] ?? false) {
    HttpFoundation\Request::setTrustedHosts([$trustedHosts]);
}

$kernel = new Application\Kernel(
    $_SERVER['APP_ENV'],
    (bool) $_SERVER['APP_DEBUG']
);

$request = HttpFoundation\Request::createFromGlobals();

$response = $kernel->handle($request);

$response->send();

$kernel->terminate(
    $request,
    $response
);
