<?php

use Feed\AbstractFeed;
use Feed\FeedMain;
use Post\Post;
use User\User;

class FeedTest extends PHPUnit_Framework_TestCase {
    protected function setUp() {
        $this->createRedis()->flushall();
    }

    public function testSimple() {
        $Feed = $this->createFeed();
        $this->assertInstanceOf(AbstractFeed::class, $Feed);
    }

    public function testAddPost() {
        $Feed = $this->createFeed();

        $User = $this->createUser();
        $User->setId(1);
        $User->save();

        $Post = $this->createPost();
        $Post->setOwner($User);
        $Post->setId(1);
        $Post->set(Post::FIELD_CREATE_AT, 1);
        $Post->save();
        $Feed->savePost($Post);

        $Post = $this->createPost();
        $Post->setOwner($User);
        $Post->setId(2);
        $Post->set(Post::FIELD_CREATE_AT, 2);
        $Post->save();
        $Feed->savePost($Post);

        $Post = $this->createPost();
        $Post->setOwner($User);
        $Post->setId(3);
        $Post->set(Post::FIELD_CREATE_AT, 10);
        $Post->save();
        $Feed->savePost($Post);

        $Post = $this->createPost();
        $Post->setOwner($User);
        $Post->setId(4);
        $Post->set(Post::FIELD_CREATE_AT, 15);
        $Post->save();
        $Feed->savePost($Post);

        $Post = $this->createPost();
        $Post->setOwner($User);
        $Post->setId(5);
        $Post->set(Post::FIELD_CREATE_AT, 20);
        $Post->save();
        $Feed->savePost($Post);

        $Post = $this->createPost();
        $Post->setOwner($User);
        $Post->setId(6);
        $Post->set(Post::FIELD_CREATE_AT, 30);
        $Post->save();
        $Feed->savePost($Post);

        $Post = $this->createPost();
        $Post->setOwner($User);
        $Post->setId(7);
        $Post->set(Post::FIELD_CREATE_AT, 50);
        $Post->save();
        $Feed->savePost($Post);

        $Posts = $Feed->getPosts("+inf", 0, 1);
        $this->assertEquals([7=>$Post], $Posts);
    }


    private function createFeed() {
        return new FeedMain($this->createRedis());
    }

    private function createRedis() {
        return \Kernel\Kernel::getInstance()->getConnectionFactory()->getRedis('test');
    }

    private function createPost() {
        return new Post();
    }

    private function createUser() {
        return new User();
    }
}