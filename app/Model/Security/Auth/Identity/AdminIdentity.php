<?php

namespace App\Model\Security\Users;

use App\Model\Modules\Admin\Permissions;
use App\Security\User\SessionIdentity;

/**
 * Class AdminUser
 * @package App\Model\Security\Users
 */
final class AdminIdentity extends SessionIdentity
{
    public array $permissions = [];
    public string $lastLogin;
    public int $redactorId;

    /**
     * @param array $permissions
     * @param string $lastLogin
     * @param int $redactorId
     */
    public function extendSessionIdentity(
        array $permissions,
        string $lastLogin,
        int $redactorId
    ): void {
        $this->permissions = $permissions;
        $this->lastLogin = $lastLogin;
        $this->redactorId = $redactorId;
    }

    /**
     * @return bool
     */
    public function hasFullPermission(): bool {
        return Permissions::checkPermission($this->permissions, Permissions::ADMIN_FULL);
    }

    /**
     * @param string $node
     * @return bool
     */
    public function hasPermission(string $node): bool {
        return Permissions::checkPermission($this->permissions, $node);
    }
}