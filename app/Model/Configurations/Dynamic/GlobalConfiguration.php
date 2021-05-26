<?php

namespace App\Model\Configurations\Dynamic;

use App\Model\Admin\AbstractConfiguration;
use Nette\Caching\Storage;
use Throwable;

/**
 * Class GlobalConfiguration
 * @package App\Model\Configurations\Dynamic
 */
class GlobalConfiguration extends AbstractConfiguration
{
    const APPLICATION_TRANSLATION = "application.translation";
    const APPLICATION_NAME = "application.name";
    const APPLICATION_DESCRIPTION = "application.admin";

    /**
     * GlobalConfiguration constructor.
     * @param Storage $storage
     * @param string $file
     * @throws Throwable
     */
    public function __construct(Storage $storage, string $file)
    {
        parent::__construct($file, $storage);
    }
}