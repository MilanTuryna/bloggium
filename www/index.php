<?php

declare(strict_types=1);

/**
 * A modern blog-system BLoggium created in PHP & Nette.
 *
 * @author Miloslav Turyna
 * @see https://github.com/MilanTuryna/bloggium
 */

require __DIR__ . '/../vendor/autoload.php';

App\Bootstrap::boot()
	->createContainer()
	->getByType(Nette\Application\Application::class)
	->run();
