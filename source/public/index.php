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

$isAuth = isset($_SESSION['user_id']) ? true : false;
if ($isAuth) {
    $User = Kernel::getInstance()->getApplication()->getSessionUser();
} else {
    $User = null;
}


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

        header('Content-Type: application/json');

        break;

    case 'post/add':
        $User = Kernel::getInstance()->getApplication()->getSessionUser();

        $PostProvider = new \Post\PostProvider();
        $Post = $PostProvider->createPost($User, $_GET['title'], $_GET['content'], array_map('trim', explode(',', $_GET['tags'])));

        $content = json_encode($Post->export());

        header('Content-Type: application/json');

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

        header('Content-Type: application/json');

        break;

    case 'register':
        $Redis = Kernel::getInstance()->getConnectionFactory()->getRedis('default');
        $UserAuthorizer = new \User\UserAuthorizer($Redis);

        try {
            $User = $UserAuthorizer->registerUser($_GET['email'], $_GET['name'], $_GET['password']);
            $_SESSION['user_id'] = $User->getId();
            $content = ['register' => true];
        } catch (Exception $Ex) {
            $content = ['register' => false, 'message' => $Ex->getMessage()];
        }


        header('Content-Type: application/json');

        break;

    case 'login':
        $Redis = Kernel::getInstance()->getConnectionFactory()->getRedis('default');
        $UserAuthorizer = new \User\UserAuthorizer($Redis);

        $User = $UserAuthorizer->auth($_GET['name'], $_GET['password']);
        if ($User) {
            $_SESSION['user_id'] = $User->getId();
            $content = ['auth' => true];
        } else {
            $content = ['auth' => false];
        }

        header('Content-Type: application/json');

        break;

    default:
        $TemplateRender = new TemplateRender();

        $data = [
            'isAuth' => $isAuth,
        ];
        if ($isAuth) {
            $data['user'] = $User->export();
            unset($data['user']['password']);
        } else {
            $data['user'] = [];
        }

        $content = $TemplateRender->render('main', $data);
}

if (is_array($content)) {
    $content = json_encode($content);
}
echo $content;