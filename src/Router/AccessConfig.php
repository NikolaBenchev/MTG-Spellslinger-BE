<?php

namespace App\Router;

class AccessConfig {
    public const EXCLUDED_ROUTES = [];
    public const PUBLIC_ROUTES = [];

    //? users.delete, user update if(user.uuid != self.uuid)
    public const ADMIN_ROUTES = [];

    const LIST = 'list';
    const GET = 'get';
    const CREATE = 'create';
    const UPDATE = 'update';
    const DELETE = 'delete';

    public static function getUserRoutes() {
        return [
            self::LIST,
            // self::GET,
            self::CREATE,
            // self::UPDATE,
            self::DELETE
        ];
    }
}