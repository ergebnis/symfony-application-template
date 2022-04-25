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

namespace App\Test\Unit\Entity;

use App\Entity;
use App\Test;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \App\Entity\Example
 */
final class ExampleTest extends Framework\TestCase
{
    use Test\Util\Helper;

    public function testFromNameReturnsExample(): void
    {
        $name = self::faker()->sentence;

        $example = Entity\Example::fromName($name);

        self::assertSame($name, $example->name());
        self::assertMatchesRegularExpression('/^[0-9a-fA-F]{8}(\-[0-9a-fA-F]{4}){3}\-[0-9a-fA-F]{12}$/', $example->id());
    }
}
