<?php

namespace App\Security\User;

/**
 * Class Credentials
 */
class Credentials
{
    /**
     * @var string Identification of user can be name, phone number or email
     */
    private string $identification;
    private string $password;
    private ?int $id;

    /**
     * Credentials constructor.
     * @param string $identification
     * @param string $password
     * @param int|null $id
     */
    public function __construct(string $identification, string $password, ?int $id = null)
    {
        $this->identification = $identification;
        $this->password = $password;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIdentification(): string
    {
        return $this->identification;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }
}