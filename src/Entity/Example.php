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

namespace App\Entity;

use Doctrine\ORM;
use Ramsey\Uuid;

#[ORM\Mapping\Entity]
#[ORM\Mapping\Table(name: 'example')]
final class Example
{
    #[ORM\Mapping\Id]
    #[ORM\Mapping\GeneratedValue(strategy: 'NONE')]
    #[ORM\Mapping\Column(
        name: 'id',
        type: 'string',
        length: 36,
    )]
    private string $id;

    #[ORM\Mapping\Column(
        name: 'name',
        type: 'string',
    )]
    private string $name;

    private function __construct(string $name)
    {
        $this->id = Uuid\Uuid::uuid4()->toString();
        $this->name = $name;
    }

    public static function fromName(string $name): self
    {
        return new self($name);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}
