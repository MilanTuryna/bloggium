<?php


namespace App\Presenters;


use App\Forms\FlashMessages;
use App\Model\Modules\Admin\Permissions;
use App\Model\Repository\UserRepository\AdminRepository;
use App\Model\Security\Auth\Authenticator\Specific\AdminAuthenticator;
use Nette\Application\AbortException;
use Nette\Localization\Translator;

/**
 * Class AdminBasePresenter
 * @package App\Presenters
 */
abstract class AdminBasePresenter extends BasePresenter
{
    private AdminAuthenticator $adminAuthenticator;
    private AdminRepository $adminRepository;
    private string $permissionNode;

    private Translator $translator;

    /**
     * AdminBasePresenter constructor.
     * @param AdminAuthenticator $adminAuthenticator
     * @param AdminRepository $adminRepository
     * @param string $permissionNode
     */
    public function __construct(AdminAuthenticator $adminAuthenticator, AdminRepository $adminRepository, string $permissionNode = Permissions::SPECIAL_WITHOUT_PERMISSION)
    {
        parent::__construct(true);

        $this->adminAuthenticator = $adminAuthenticator;
        $this->adminRepository = $adminRepository;
        $this->permissionNode = $permissionNode;
    }

    /**
     * @throws AbortException
     */
    public function startup(): void
    {
        parent::startup();
        $userID = $this->adminAuthenticator->getId();
        $adminIdentity = $userID ? $this->adminRepository->getAdminIdentity($userID) : null;
        if($adminIdentity) {
            if(!$adminIdentity->hasPermission($this->permissionNode)) {
                $this->flashMessage("admin.auth.NON_PERMISSION_ACCESS", FlashMessages::DANGER);
                $this->redirect("Main:home");
            }
            $this->template->adminIdentity = $adminIdentity;
        } else {
            $translatedMessage = $this->translator->translate('admin.auth.LOGIN_NEEDED');
            $this->flashMessage($translatedMessage, FlashMessages::DANGER);
            $this->redirect(":Admin:Auth:Login");
        }
    }
}