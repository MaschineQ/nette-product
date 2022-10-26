<?php

use Nette\Configurator;

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();

$configurator = new Configurator();
$appDir = dirname(__DIR__ . '/..');

$configurator->setTempDirectory($appDir . '/temp');

$configurator->addConfig(__DIR__ . '/../config/services.neon');
$configurator->addConfig(__DIR__ . '/../config/local.neon');

return $configurator->createContainer();