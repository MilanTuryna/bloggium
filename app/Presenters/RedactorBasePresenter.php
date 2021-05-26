<?php


namespace App\Presenters;

use App\Forms\FlashMessages;
use App\Model\Repository\UserRepository\RedactorRepository;
use App\Model\Security\Auth\Authenticator\Specific\RedactorAuthenticator;
use Nette\Application\AbortException;
use Nette\Localization\Translator;

/**
 * Class RedactorBasePresenter
 * @package App\Presenters
 */
abstract class RedactorBasePresenter extends BasePresenter
{
    private RedactorAuthenticator $redactorAuthenticator;
    private RedactorRepository $redactorRepository;

    private Translator $translator;

    /**
     * RedactorBasePresenter constructor.
     * @param RedactorAuthenticator $redactorAuthenticator
     * @param RedactorRepository $redactorRepository
     */
    public function __construct(RedactorAuthenticator $redactorAuthenticator, RedactorRepository $redactorRepository)
    {
        parent::__construct(true);

        $this->redactorAuthenticator = $redactorAuthenticator;
        $this->redactorRepository = $redactorRepository;
    }

    /**
     * @throws AbortException
     */
    public function startup(): void
    {
        parent::startup();

        $userID = $this->redactorAuthenticator->getId();
        $redactorIdentity = $userID ? $this->redactorRepository->getRedactorIdentity($userID) : null;
        if($redactorIdentity) {
            $this->template->redactorIdentity = $redactorIdentity;
        } else {
            $translatedMessage = $this->translator->translate('redactor.auth.LOGIN_NEEDED');
            $this->flashMessage($translatedMessage, FlashMessages::DANGER);
            $this->redirect(":Admin:Auth:Login");
        }
    }
}