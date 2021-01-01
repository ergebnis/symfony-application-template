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

namespace App\Test\AutoReview;

use App\Kernel;
use Ergebnis\Test\Util;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @coversNothing
 */
final class SrcCodeTest extends Framework\TestCase
{
    use Util\Helper;

    public function testSrcClassesHaveUnitTests(): void
    {
        self::assertClassesHaveTests(
            __DIR__ . '/../../src',
            'App\\',
            'App\\Test\\Unit\\',
            [
                Kernel::class,
            ]
        );
    }
}
