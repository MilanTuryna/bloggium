<?php

declare(strict_types=1);

/**
 * A modern blog-system BLoggium created in PHP & Nette.
 * @author Miloslav Turyna
 * @see https://github.com/MilanTuryna/bloggium
*/

// production
require __DIR__ . '/../vendor/autoload.php';

// debug & maintenance
$allowedIps = [];
if(count($allowedIps) > 0 && !in_array($_SERVER["REMOTE_ADDR"], $allowedIps)) die("We're sorry, but the site is currently under maintenance.");

App\Bootstrap::boot()
	->createContainer()
	->getByType(Nette\Application\Application::class)
	->run();
