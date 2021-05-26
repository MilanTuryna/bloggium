<?php

namespace App\Presenters\AdminModule;

use App\Presenters\BasePresenter;

/**
 * Class LoginPresenter
 * @package App\Presenters\AdminModule
 */
class AuthPresenter extends BasePresenter
{
    /**
     * LoginPresenter constructor.
     */
    public function __construct()
    {
        parent::__construct(true);
    }
}