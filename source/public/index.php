<?php

use Kernel\Kernel;
use Template\TemplateRender;

/** @var Kernel $Kernel */
$Kernel = include __DIR__ . '/../bootstrap/bootstrap.php';

$TemplateRender = new TemplateRender();

$template = $TemplateRender->render('main', [
    'content' => 'hello world',
]);

echo $template;