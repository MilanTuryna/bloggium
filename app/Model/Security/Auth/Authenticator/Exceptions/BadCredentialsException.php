<?php

namespace App\Authenticator\Exceptions;

/**
 * The client tries to log with bad password or bad identification name (username, tel. number, email)
 * Class BadCredentialsException
 * @package App\Authenticator\Exceptions
 */
class BadCredentialsException extends \Exception
{}