<?php

namespace App\Presenters;

use App\Model\Configurations\GlobalConfiguration;
use Nette\Application\Helpers;
use Nette\Application\UI\Presenter;
use Nette;
use Contributte;

/**
 * Class BasePresenter
 * @package App\Presenters
 */
abstract class BasePresenter extends Presenter
{
    private bool $startupInit;

    /** @var Nette\Localization\Translator @inject */
    public Nette\Localization\Translator $translator;

    /** @var Contributte\Translation\LocalesResolvers\Session @inject */
    public Contributte\Translation\LocalesResolvers\Session $translatorSessionResolver;

    /** @var GlobalConfiguration */
    public GlobalConfiguration $globalConfiguration;

    /**
     * BasePresenter constructor.
     * @param bool $startupInit
     */
    public function __construct(bool $startupInit = true)
    {
        parent::__construct();

        $this->startupInit = $startupInit;
        $this->translatorSessionResolver->setLocale($this->globalConfiguration->getValue(GlobalConfiguration::APPLICATION_TRANSLATION));
    }

    /**
     * @return array
     */
    public function formatTemplateFiles(): array
    {
        [$module, $presenter] = Helpers::splitName($this->getName());
        $dir = dirname(static::getReflection()->getFileName());
        return [
            "$dir/$module/$presenter/latte/$this->view.latte",
        ];
    }

    /**
     * @return Nette\Localization\Translator
     */
    public function getTranslator(): Nette\Localization\Translator
    {
        return $this->translator;
    }

    /**
     * @return Contributte\Translation\LocalesResolvers\Session
     */
    public function getTranslatorSessionResolver(): Contributte\Translation\LocalesResolvers\Session
    {
        return $this->translatorSessionResolver;
    }
}