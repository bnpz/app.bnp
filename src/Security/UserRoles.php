<?php
namespace App\Security;

/**
 * Class UserRoles
 * @package App\Security
 */
class UserRoles
{
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_USER = "ROLE_USER";
    const ROLE_EDITOR = "ROLE_EDITOR";

    /**
     * @return string[]
     */
    public static function allRoles()
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_USER,
            self::ROLE_EDITOR
        ];
    }

}