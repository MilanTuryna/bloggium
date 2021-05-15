<?php

namespace App\Security\Auth\Authenticator;

use App\Security\User\Credentials;
use App\Authenticator\Exceptions\ClientUnloggedException;
use App\Authenticator\Exceptions\BadCredentialsException;
use App\Model\Repository\BaseUserRepository;
use App\Model\Security\Authenticator\IAuthenticator;

use Nette\Http\Session;
use Nette\Security\Passwords;

/**
 * Class Authenticator
 * @package App\Security\Authenticator
 */
abstract class AbstractAuthenticator implements IAuthenticator
{
    private BaseUserRepository $userRepository;
    private Passwords $passwords;
    private Session $session;

    private string $sessionSection;

    /**
     * AdminAuthenticator constructor.
     * @param BaseUserRepository $userRepository
     * @param Passwords $passwords
     * @param Session $session
     * @param string $sessionSection
     */
    public function __construct(BaseUserRepository $userRepository, Passwords $passwords, Session $session, string $sessionSection = "abstract_user_authenticator")
    {
        $this->userRepository = $userRepository;
        $this->passwords = $passwords;
        $this->session = $session;
        $this->sessionSection = $sessionSection;
    }

    /**
     * @param Credentials $inputCredentials
     * @param string $mode
     * @param string $expiration
     * @throws BadCredentialsException
     */
    public function login(Credentials $inputCredentials, ?string $mode = null, string $expiration = self::EXPIRATION): void
    {
        $identification = $inputCredentials->getIdentification();
        $password = $inputCredentials->getPassword();
        $userIdentity = $this->userRepository->getUserIdentity($identification);

        $section = $this->session->getSection($this->sessionSection);
        $section->setExpiration($expiration);

        if($userIdentity && $this->passwords->verify($password, $userIdentity->hashedPassword)) {
            $section->id = $userIdentity->id;
            $section->mode = $mode ?: $userIdentity->mode;
            $this->userRepository->updateUserLastLogin($userIdentity->id);
            return;
        }

        throw new BadCredentialsException;
    }

    /**
     * @param string $mode
     * @throws ClientUnloggedException
     */
    public function changeMode(string $mode): void {
        $section = $this->session->getSection($this->sessionSection);
        if(!$section->id) throw new ClientUnloggedException();
        $section->mode = $mode;
    }

    /**
     * @throws ClientUnloggedException
     */
    public function logout(): void
    {
        $section = $this->session->getSection($this->sessionSection);
        if(!$section->id) throw new ClientUnloggedException();
        $section->remove();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        $section = $this->session->getSection($this->sessionSection);
        return $section->id ?? null;
    }
}