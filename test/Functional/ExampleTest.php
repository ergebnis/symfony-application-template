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

namespace App\Test\Functional;

use PHPUnit\Framework;
use Symfony\Bundle\FrameworkBundle;

#[Framework\Attributes\CoversNothing()]
final class ExampleTest extends FrameworkBundle\Test\WebTestCase
{
    public function testTrueIsTrue(): void
    {
        self::assertTrue(true);
    }
}
