<?php

use Feed\FeedMain;
use Feed\FeedTag;
use Feed\FeedType;
use Feed\FeedUser;
use Kernel\Kernel;
use Post\Post;
use Template\TemplateRender;
use User\User;
use Utils\Time;

/** @var Kernel $Kernel */
$Kernel = include __DIR__ . '/../bootstrap/bootstrap.php';

$c = 'Минимализм минимализму рознь. Здесь нужно без фанатизма) Все-таки некоторые моменты я бы по-ярче сделал или выделил другим способом. </br>
                </br>
                Сделай узкий сайт фиксированной ширины, а поня рисуй на определенном расстоянии слева. Расстояние зависит от ширины моника: если моник "узкий" (или девайсы), то рисовать не далеко (понь будет в углу). Если широкий, то на некотором расстоянии, но уже не в углу. Думаю, так должно хорошо смотреться.
                </br>
                </br>
                Все мои рекомендации, только рекомендации, ты же знаешь
            ';


switch ($_GET['action'] ?: '') {

    case 'get/feed':
        $feedType = $_GET['feed'];
        $feedName = '';

        if (strpos($feedType, ':')) {
            $feedExplode = explode(':', $feedType);
            $feedType = $feedExplode[0];
            $feedName = $feedExplode[1];
        }

        $Feed = Kernel::getInstance()->getFeedProvider()->getFeed($feedType);

        switch ($feedType) {
            case FeedType::MAIN:
                /** @var FeedMain $Feed */
                $Posts = $Feed->getPosts(Time::getTime(), 0, 10);
                break;

            case FeedType::TAG:
                /** @var FeedTag $Feed */
                $Posts = $Feed->getPosts($feedName, Time::getTime(), 0, 10);
                break;

            case FeedType::USER:
                /** @var FeedUser $Feed */
                $Posts = $Feed->getPosts($feedName, Time::getTime(), 0, 10);
                break;

            default:
                $Posts = [];
        }

        $postsData = [];
        foreach ($Posts as $Post) {
            $postsData[] = $Post->export();
        }

        $content = json_encode($postsData);
        break;

    case 'add/post':
        $User = Kernel::getInstance()->getApplication()->getSessionUser();

        $PostProvider = new \Post\PostProvider();
        $Post = $PostProvider->createPost($User, '.hello_world 1', $c);

        $content = json_encode($Post->export());

        break;

    case 'get/posts':
        $Owner = new User([
            User::FIELD_NAME => 'Йакуд',
            User::FIELD_EMAIL => 'yakudgm@gmail.com',
            User::FIELD_ID => 1,
        ]);

        $Post[0] = new Post([
            Post::FIELD_ID => 1,
            Post::FIELD_TITLE => '.hello_world 1',
            Post::FIELD_CONTENT => $c,
            Post::FIELD_TAGS => ['tag1', 'tag2'],
            Post::FIELD_USER_OWNER => $Owner,
        ]);
        $Post[1] = new Post([
            Post::FIELD_ID => 2,
            Post::FIELD_TITLE => '.hello_world 2',
            Post::FIELD_CONTENT => $c,
            Post::FIELD_TAGS => ['tag1', 'tag2'],
            Post::FIELD_USER_OWNER => $Owner,
        ]);
        $Post[2] = new Post([
            Post::FIELD_ID => 3,
            Post::FIELD_TITLE => '.hello_world 3',
            Post::FIELD_CONTENT => $c,
            Post::FIELD_TAGS => ['tag1', 'tag2'],
            Post::FIELD_USER_OWNER => $Owner,
        ]);
        $Post[3] = new Post([
            Post::FIELD_ID => 4,
            Post::FIELD_TITLE => '.hello_world 4',
            Post::FIELD_CONTENT => $c,
            Post::FIELD_TAGS => ['tag1', 'tag2'],
            Post::FIELD_USER_OWNER => $Owner,
        ]);

        $content = json_encode([
            $Post[3]->export(),
            $Post[2]->export(),
            $Post[1]->export(),
            $Post[0]->export(),
        ]);
        break;

    default:
        $TemplateRender = new TemplateRender();
        $content = $TemplateRender->render('main', [
            'content' => 'hello world',
        ]);
}

echo $content;