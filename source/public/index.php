<?php

use Kernel\Kernel;
use Template\TemplateRender;

/** @var Kernel $Kernel */
$Kernel = include __DIR__ . '/../bootstrap/bootstrap.php';


switch ($_GET['action'] ?: '') {

    case 'get/posts':
        $content = json_encode([
          ['id' => 1, 'title' => 'Title 1', 'content' => 'Content of blog element 1'],
          ['id' => 2, 'title' => 'Title 2', 'content' => 'Content of blog element 2'],
          ['id' => 3, 'title' => 'Title 3', 'content' => 'Content of blog element 3'],
          ['id' => 4, 'title' => 'Title 4', 'content' => 'Content of blog element 4'],
          ['id' => 5, 'title' => 'Title 5', 'content' => 'Content of blog element 5'],
        ]);
        break;

    default:
        $TemplateRender = new TemplateRender();
        $content = $TemplateRender->render('main', [
            'content' => 'hello world',
        ]);
}

echo $content;