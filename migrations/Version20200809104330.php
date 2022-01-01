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

namespace App\Migration;

use Doctrine\DBAL;
use Doctrine\Migrations;

final class Version20200809104330 extends Migrations\AbstractMigration
{
    public function up(DBAL\Schema\Schema $schema): void
    {
        $this->addSql('CREATE TABLE example (id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(DBAL\Schema\Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE example');
    }
}
