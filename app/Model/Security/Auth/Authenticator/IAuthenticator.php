<?php

namespace App\Model\Security\Authenticator;

use App\Authenticator\Exceptions\ClientUnloggedException;
use App\Security\User\Credentials;

/**
 * Interface IAuthenticator
 * @package App\Model\Security\Authenticator
 */
interface IAuthenticator
{
    const EXPIRATION = '14 days';


    /**
     * @param Credentials $credentials
     * @param string $mode
     * @param string $expiration
     */
    public function login(Credentials $credentials, string $mode, string $expiration = self::EXPIRATION): void;
    /** @throws ClientUnloggedException */
    public function logout(): void;
    /**
     * @return int
     */
    public function getId(): ?int;
}