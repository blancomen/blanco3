<?php

use Config\ConfigLoader;
use Connection\ConnectionFactory;
use Kernel\Application;
use Kernel\Environment;
use Kernel\Kernel;
use Orm\Entity\EntityType;
use Orm\Provider\OrmProviderRedis;
use User\User;

require_once __DIR__ . '/path.php';
require_once PATH_VENDOR . '/autoload.php';

$Environment       = new Environment(Environment::LOCAL);
$ConfigLoader      = new ConfigLoader($Environment);
$ConnectionFactory = new ConnectionFactory($ConfigLoader);
$OrmProvider       = new OrmProviderRedis($ConnectionFactory);
$Application       = new Application();


$Kernel = new Kernel();
$Kernel->setEnvironment($Environment);
$Kernel->setConfigLoader($ConfigLoader);
$Kernel->setConnectionFactory($ConnectionFactory);
$Kernel->setOrmProvider($OrmProvider);
$Kernel->setApplication($Application);

Kernel::setInstance($Kernel);

try {
    /** @var User $SessionUser */
    $SessionUser = $Kernel->getRepository(EntityType::USER)->loadById(1);
} catch (\Orm\Repository\EntityNotFoundException $Ex) {
    $SessionUser = new User([
        User::FIELD_NAME => 'Йакуд',
        User::FIELD_EMAIL => 'yakud@mail.stop',
    ]);
    $SessionUser->save();
}

$Kernel->getApplication()->setSessionUser($SessionUser);

return $Kernel;