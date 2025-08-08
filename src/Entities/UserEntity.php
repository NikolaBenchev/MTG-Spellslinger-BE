<?php

namespace App\Entities;

class UserEntity extends Entity
{
    private string $uuid;

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    private string $displayName;

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    private string $email;
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    private string $password;
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    private $settings;
    public function getSettings()
    {
        return $this->settings;
    }

    public function setSettings($settings)
    {
        $this->settings = $settings;
    }
    private string $roleUuid;

    public function getRoleUuid()
    {
        return $this->roleUuid;
    }

    public function setRoleUuid($roleUuid)
    {
        $this->roleUuid = $roleUuid;
    }

    public function getDatabaseFields()
    {
        return [
            'uuid',
            'display_name',
            'email',
            'password',
            'settings',
            'role_uuid'
        ];
    }

    public function getSerializableFields()
    {
        return [
            'uuid',
            'displayName',
            'email',
            'password',
            'settings',
            'roleUuid'
        ];
    }
};
