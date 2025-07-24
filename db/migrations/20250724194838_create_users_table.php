<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public function up(): void
    {
        $this->execute(
            "CREATE TABLE user(
                uuid varchar(255),
                display_name varchar(32) NOT NULL,
                email varchar(32) NOT NULL,
                password varchar(32) NOT NULL,
                settings JSON,
                role_uuid varchar(32) NOT NULL,
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
