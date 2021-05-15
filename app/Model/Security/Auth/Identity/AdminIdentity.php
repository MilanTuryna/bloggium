<?php

namespace App\Model\Security\Users;

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
}