<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Ramsey\Uuid\Uuid;

final class CreateUserRanksTable extends AbstractMigration
{
    public function up(): void
    {
        $this->execute(
            "CREATE TABLE role(
                uuid varchar(32),
                name varchar(32) UNIQUE NOT NULL,
                description TEXT,
                PRIMARY KEY (uuid)
            );"
        );

        $ranks = [
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => 'User',
                'description' => 'Most basic role. Has access to only his decks/settings.'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => 'Admin',
                'description' => 'Super user role. Has access to everything.'
            ]
        ];

        $this->table('role')->insert($ranks)->save();
    }

    public function down(): void
    {
        $this->execute("
            DROP TABLE role;
        ");
    }
}
