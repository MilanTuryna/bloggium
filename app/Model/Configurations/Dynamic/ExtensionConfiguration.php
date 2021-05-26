<?php


namespace App\Model\Configurations\Dynamic;


use App\Model\Admin\AbstractConfiguration;
use Nette\Caching\Storage;
use Throwable;

/**
 * Class ExtensionConfiguration
 * @package App\Model\Configurations\Dynamic
 */
class ExtensionConfiguration extends AbstractConfiguration
{
    const RECAPTCHA_SECRET_KEY = "dynamic.recaptcha.secretKey";
    const RECAPTCHA_SITE_KEY = "dynamic.recaptcha.siteKey";
    const RECAPTCHA_ENABLED = "dynamic.recaptcha.enabled";

    /**
     * ExtensionConfiguration constructor.
     * @param string $filePath
     * @param Storage $storage
     * @throws Throwable
     */
    public function __construct(string $filePath, Storage $storage)
    {
        parent::__construct($filePath, $storage);
    }

    /**
     * @return string
     */
    public function getServiceName(): string {
        return "admin.configurations.extensionConfiguration";
    }
}