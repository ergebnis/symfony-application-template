<?php

declare(strict_types=1);

/**
 * Copyright (c) 2020-2023 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/symfony-application-template
 */

namespace App\Test\Functional;

use Symfony\Bundle\FrameworkBundle;

/**
 * @internal
 *
 * @coversNothing
 */
final class ExampleTest extends FrameworkBundle\Test\WebTestCase
{
    public function testTrueIsTrue(): void
    {
        self::assertTrue(true);
    }
}
