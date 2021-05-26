<?php

namespace App\Model\Repository\UserRepository;

use App\Model\Modules\Admin\Permissions;
use App\Model\Repository\BaseUserRepository;
use App\Model\Security\Users\AdminIdentity;

/**
 * Class AdminRepository
 * @package App\Model\Repository
 */
class AdminRepository extends BaseUserRepository
{
    /**
     * @param int $id
     * @return AdminIdentity
     */
    public function getAdminIdentity(int $id): ?AdminIdentity {
        $row = $this->findUserByIdentificationName($id, ["*"], true);
        if(!$row) return null;
        $adminIdentity = new AdminIdentity($row->username, $row->email, $row->password, $row->phoneNumber, $row->mode, $row->id);
        $adminPermissions = Permissions::listToArray($row->permissions);
        $adminIdentity->extendSessionIdentity($adminPermissions, $adminIdentity->lastLogin, $row->redactorId);
        return $adminIdentity;
    }
}