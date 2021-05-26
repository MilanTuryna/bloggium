<?php

namespace App\Model\Modules\Admin;

use Nette\Localization\Translator;

/**
 * Class Permissions
 * @package App\Model\Modules\Admin
 */
final class Permissions
{
    private Translator $translator;

    const ADMIN_FULL = "*";

    const SPECIAL_WITHOUT_PERMISSION = "admin.special_without_permission"; /** Used for checking automatic checking in AdminBasePresenter */

    /**
     * Permissions constructor.
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }


    /**
     * Returning a associative array with constant permissions nodes and user-friendly description of this permission (will be used for select/radios inputs)
     * @return array
     */
    public static function getSelectBox(): array {
        return [
            self::ADMIN_FULL => "Správce - plná práva: *",

        ];
    }

    /**
     * Returning a array with all permissions nodes, will be used Fulladmin group permissions
     * @return array
     */
    public static function getAllPermissions(): array {
        return array_keys(self::getSelectBox());
    }

    /**
     * @param string $unparsedList
     * @return array
     */
    public static function listToArray(string $unparsedList): array {
        return array_filter(explode(",", preg_replace('/\s+/', '', $unparsedList)));
    }

    /**
     * @param $parsedList
     * @return string
     */
    public static function arrayToUnparsedList($parsedList): string {
        return implode(",", $parsedList);
    }

    /**
     * Checking if permission node is includes in permissions
     * @param array $permArray
     * @param string $node
     * @return bool
     */
    public static function checkPermission(array $permArray, string $node): bool {
        return in_array($node, $permArray) || in_array(self::ADMIN_FULL, $permArray) || $node === Permissions::SPECIAL_WITHOUT_PERMISSION;
    }
}