<?php

declare(strict_types=1);

namespace App;

use App\Model\Configurations\ExtensionConfiguration;
use Nette\Bootstrap\Configurator;
use Nette\Caching\Storages\FileStorage;
use Throwable;
use Tracy\Debugger;

/**
 * Class Bootstrap
 * @package App
 */
class Bootstrap
{
    /**
     * @return Configurator
     * @throws Throwable
     */
	public static function boot(): Configurator
	{
		$configurator = new Configurator;
		$appDir = dirname(__DIR__);

		$configurator->setDebugMode(true); // enable for your remote IP
		$configurator->enableTracy($appDir . '/log');

        Debugger::$strictMode = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_USER_NOTICE;

        $tempDirectory = $appDir . '/temp';
		$configurator->setTempDirectory($tempDirectory);

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

        $storage = new FileStorage($tempDirectory);
        $extensionConfiguration = new ExtensionConfiguration(__DIR__ . '/Config/dynamic/extensions.neon', $storage);
        $configurator->addServices([$extensionConfiguration->getServiceName() => $extensionConfiguration]); // registering $extensionConfiguration to DI
        $configurator->addDynamicParameters([ // adding dynamic parameters for use in registered configurations
            ExtensionConfiguration::RECAPTCHA_SITE_KEY => $extensionConfiguration->getValue(ExtensionConfiguration::RECAPTCHA_SITE_KEY),
            ExtensionConfiguration::RECAPTCHA_SECRET_KEY => $extensionConfiguration->getValue(ExtensionConfiguration::RECAPTCHA_SECRET_KEY)
        ]);

        $configurator->addConfig(__DIR__ . '/Config/application.neon');
        $configurator->addConfig(__DIR__ . '/Config/parameters.neon');
        $configurator->addConfig(__DIR__ . '/Config/extensions.neon');
        $configurator->addConfig(__DIR__ . '/../settings/production.neon');
        $configurator->addConfig(__DIR__ . '/Config/services.neon');

		return $configurator;
	}
}
