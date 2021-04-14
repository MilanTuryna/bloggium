<?php

namespace App\Model\Admin\Roles;

/**
 * Class Permission
 * @package App\Model\Admin\Roles
 * TODO: Support more Languages
 */
class Permission
{
    const ADMIN_FULL = "*";

    /**
     * @return array
     */
    public static function getSelectBox(): array {
        return [
            self::ADMIN_FULL => ""
        ];
    }

    /**
     * @return array
     */
    public static function getAllPermissions(): array {
        return array_keys(self::getSelectBox());
    }
}