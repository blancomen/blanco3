<?php

use Kernel\Kernel;

/** @var Kernel $Kernel */
$Kernel = include __DIR__ . '/../bootstrap/bootstrap.php';

$ConnectionFactory = $Kernel->getConnectionFactory();
$TestRedis = $ConnectionFactory->getRedis('test');

echo "Is test redis connect: ", $TestRedis->isConnected(), PHP_EOL;