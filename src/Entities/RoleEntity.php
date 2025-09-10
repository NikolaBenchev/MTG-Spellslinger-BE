<?php

namespace App\Entities;

class RoleEntity extends Entity
{
    public const USER = 'user';
    public const ADMIN = 'admin';
    public const ROOT = 'root';

    public const ROLES = [self::USER, self::ADMIN, self::ROOT];

    protected ?string $uuid = null;
    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid)
    {
        $this->uuid = $uuid;
    }

    protected ?string $name = null;
    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    protected ?string $description = null;
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getSerializableFields()
    {
        return [
            'uuid',
            'name',
            'description'
        ];
    }

    public function getDatabaseFields()
    {
        return [
            'uuid',
            'name',
            'description'
        ];
    }
}
