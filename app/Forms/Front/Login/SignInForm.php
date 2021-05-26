<?php

namespace App\Forms;

use App\Authenticator\Exceptions\BadCredentialsException;
use App\Model\Security\Authenticator\IAuthenticator;

use Nette\Application\AbortException;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

/**
 * Class SignInForm
 * @package App\Forms
 */
class SignInForm
{
    private Presenter $presenter;
    private IAuthenticator $authenticator;
    private string $redirect;

    /**
     * SignInForm constructor.
     * @param Presenter $presenter
     * @param IAuthenticator $authenticator
     * @param string $redirect
     */
    public function __construct(Presenter $presenter, IAuthenticator $authenticator, string $redirect)
    {
        $this->presenter = $presenter;
        $this->authenticator = $authenticator;
        $this->redirect = $redirect;
    }

    public function create(): Form {
        $form = new Form;
        $form->addText('identificationName')->setRequired(true);
        $form->addText('rawPassword')->setRequired(true);
        $form->addText('preferredMode')->setRequired(true);
        $form->addSubmit('submit')->setRequired(true);
        $form->onSuccess[] = [$this, 'success'];
        $form->onError[] = function() use ($form) {
            foreach($form->getErrors() as $error) $this->presenter->flashMessage($error, FlashMessages::DANGER);
        };
        return $form;
    }

    /**
     * @param Form $form
     * @param SignInFormData $values
     * @throws AbortException
     */
    public function success(Form $form, SignInFormData $values) {
        try {
            $this->authenticator->login($values->getCredentials(), $values->preferredMode);
            $this->presenter->flashMessage("uspesne prihlasen", FlashMessages::SUCCESS);
            $this->presenter->redirect($this->redirect);
        } catch (BadCredentialsException $exception) {
            $form->addError("spatne heslo a jmeno");
        }
    }
}