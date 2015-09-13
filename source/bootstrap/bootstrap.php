<?php

use Config\ConfigLoader;
use Kernel\Environment;
use Kernel\Kernel;

require_once __DIR__ . '/path.php';
require_once PATH_VENDOR . '/autoload.php';

$Environment       = new Environment(Environment::LOCAL);
$ConfigLoader      = new ConfigLoader($Environment);

$Kernel = new Kernel();
$Kernel->setEnvironment($Environment);
$Kernel->setConfigLoader($ConfigLoader);

return $Kernel;