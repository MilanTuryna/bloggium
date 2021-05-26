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
    public string $lastLogin;
    public string $defaultArticleOption;

    /**
     * @param string $signature
     * @param string $lastLogin
     * @param string $defaultArticleOption
     */
    public function extendSessionIdentity(
        string $signature,
        string $lastLogin,
        string $defaultArticleOption
    ) {
        $this->signature = $signature;
        $this->lastLogin = $lastLogin;
        $this->defaultArticleOption = $defaultArticleOption;
    }
}