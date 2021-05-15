<?php


namespace App\Security\User;

/**
 * Class Identity
 * @package App\Security\User
 */
class SessionIdentity
{
    public string $username;
    public string $email;
    public string $hashedPassword;
    public ?string $phoneNumber;
    public string $mode;
    public int $id;

    /**
     * Identity constructor.
     * @param string $username
     * @param string $email
     * @param string $hashedPassword
     * @param string|null $phoneNumber
     * @param string $mode
     * @param int $id
     */
    public function __construct(string $username, string $email, string $hashedPassword, ?string $phoneNumber, string $mode, int $id)
    {
        $this->username = $username;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->phoneNumber = $phoneNumber;
        $this->mode = $mode;
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isEmailValid(): bool {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }
}