<?php


namespace App\Forms;

use App\Security\User\Credentials;

/**
 * Class SignInFormData
 * @package App\Forms
 */
class SignInFormData
{
    public string $identificationName;
    public string $rawPassword;
    public string $preferredMode;

    /**
     * @return Credentials
     */
    public function getCredentials(): Credentials {
        return new Credentials($this->identificationName, $this->rawPassword);
    }
}