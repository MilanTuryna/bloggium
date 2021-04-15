<?php

namespace App\Model\Configurations;

use App\Model\Admin\Configuration;
use Nette\Caching\Storage;
use Throwable;

/**
 * Class GlobalConfiguration
 * @package App\Model\Configurations
 */
class GlobalConfiguration extends Configuration
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