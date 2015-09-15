<?php
use Post\Post;
use User\User;

class PostTest extends PHPUnit_Framework_TestCase {
    public function testSimple() {
        $Post = $this->createPost();
        $this->assertInstanceOf(Post::class, $Post);
    }

    public function testSaveLoad() {
        $User = $this->createUser();
        $User->set(User::FIELD_LOGIN, 'yakud');
        $User->save();

        $Post = $this->createPost();
        $Post->set(Post::FIELD_TITLE, 'title');
        $Post->set(Post::FIELD_CONTENT, 'Content');
        $Post->set(Post::FIELD_USER_OWNER, $User);
        $Post->save();

        $LoadedPost = new Post();
        $LoadedPost->setId($Post->getId());
        $LoadedPost->load();

        $this->assertEquals($Post, $LoadedPost);
        $this->assertEquals($User, $LoadedPost->get(Post::FIELD_USER_OWNER));
    }

    public function createPost() {
        return new Post();
    }

    public function createUser() {
        return new User();
    }
}