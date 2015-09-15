<?php

use Config\ConfigLoader;
use Kernel\Environment;
use Kernel\Kernel;

require_once __DIR__ . '/path.php';
require_once PATH_VENDOR . '/autoload.php';

$Kernel       = new Kernel();
$Environment  = new Environment(Environment::LOCAL);
$ConfigLoader = new ConfigLoader($Environment);

$Kernel->setEnvironment($Environment);
$Kernel->setConfigLoader($ConfigLoader);

Kernel::setInstance($Kernel);

return $Kernel;