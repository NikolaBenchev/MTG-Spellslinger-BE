<?php

namespace App\Entities;

class UserEntity extends Entity
{
    protected ?string $uuid = null;
    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    protected ?string $username = null;
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    protected ?string $email = null;
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    protected ?string $password = null;
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    protected $settings = null;
    public function getSettings()
    {
        return $this->settings;
    }

    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    protected ?string $roleUuid = null;
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
            'username',
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
            'username',
            'email',
            'password',
            'settings',
            'roleUuid'
        ];
    }
};
