<?php


namespace App\Model\Security\Auth\Identity;

use App\Security\User\SessionIdentity;

/**
 * Class RedactorIdentity
 * @package App\Model\Security\Auth\Identity
 */
final class RedactorIdentity extends SessionIdentity
{
    public string $signature;
    public string $defaultArticleOption;
}