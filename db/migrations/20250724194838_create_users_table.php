<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public function up(): void
    {
        $this->execute(
            "CREATE TABLE user(
                uuid varchar(36),
                username varchar(32) UNIQUE NOT NULL,
                email varchar(32) UNIQUE NOT NULL,
                password varchar(255) NOT NULL,
                settings JSON,
                role_uuid varchar(36) NOT NULL,
                PRIMARY KEY (uuid),
                FOREIGN KEY (role_uuid) REFERENCES role(uuid)
            );"
        );
    }

    public function down(): void
    {
        $this->execute(
            "DROP TABLE user;"
        );
    }
}
