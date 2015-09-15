<?php

use Config\ConfigLoader;
use Connection\ConnectionFactory;
use Kernel\Environment;
use Kernel\Kernel;
use Orm\Provider\OrmProviderArray;
use Orm\Provider\OrmProviderRedis;

require_once __DIR__ . '/path.php';
require_once PATH_VENDOR . '/autoload.php';

$Environment       = new Environment(Environment::LOCAL);
$ConfigLoader      = new ConfigLoader($Environment);
$ConnectionFactory = new ConnectionFactory($ConfigLoader);
$OrmProvider       = new OrmProviderArray();

$Kernel = new Kernel();
$Kernel->setEnvironment($Environment);
$Kernel->setConfigLoader($ConfigLoader);
$Kernel->setConnectionFactory($ConnectionFactory);
$Kernel->setOrmProvider($OrmProvider);

Kernel::setInstance($Kernel);

return $Kernel;