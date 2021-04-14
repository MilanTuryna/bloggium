<?php

namespace App\Model\Configurations;

use App\Model\Admin\Configuration;

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
     * @param string $file
     */
    public function __construct(string $file)
    {
        parent::__construct($file);
    }
}