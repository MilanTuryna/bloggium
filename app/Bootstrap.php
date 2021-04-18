<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;
use Tracy\Debugger;

/**
 * Class Bootstrap
 * @package App
 */
class Bootstrap
{
    /**
     * @return Configurator
     */
	public static function boot(): Configurator
	{
		$configurator = new Configurator;
		$appDir = dirname(__DIR__);

		$configurator->setDebugMode(true); // enable for your remote IP
		$configurator->enableTracy($appDir . '/log');

        Debugger::$strictMode = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_USER_NOTICE;

		$configurator->setTempDirectory($appDir . '/temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

        $configurator->addConfig(__DIR__ . '/Config/application.neon');
        $configurator->addConfig(__DIR__ . '/Config/parameters.neon');
        $configurator->addConfig(__DIR__ . '/Config/extensions.neon');

        $configurator->addConfig(__DIR__ . '/../settings/production.neon');

        $configurator->addConfig(__DIR__ . '/Config/services.neon');

		return $configurator;
	}
}
