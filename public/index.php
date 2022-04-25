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

use App\Kernel;

require_once __DIR__ . '/../vendor/autoload_runtime.php';

return static function (array $context): Kernel {
    return new Kernel(
        $context['APP_ENV'],
        (bool) $context['APP_DEBUG'],
    );
};
