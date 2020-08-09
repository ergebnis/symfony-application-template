<?php

declare(strict_types=1);

namespace <namespace>;

use Doctrine\DBAL;
use Doctrine\Migrations;

final class <className> extends Migrations\AbstractMigration
{
    public function up(DBAL\Schema\Schema $schema): void
    {
<up>
    }

    public function down(DBAL\Schema\Schema $schema): void
    {
<down>
    }
}
