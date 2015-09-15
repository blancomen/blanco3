<?php
namespace Post;

use Kernel\Kernel;
use Orm\Entity\EntityType;
use User\User;
use Utils\Time;

class PostProvider {
    /**
     * @param User $User
     * @param int $title
     * @param int $content
     * @return Post
     */
    public function createPost(User $User, $title, $content) {
        $Post = new Post();
        $Post->set(Post::FIELD_USER_OWNER, $User);
        $Post->set(Post::FIELD_TITLE, $title);
        $Post->set(Post::FIELD_CONTENT, $content);
        $Post->set(Post::FIELD_CREATE_AT, Time::getTime());

        $Post->save();

        return $Post;
    }

    /**
     * @param int $postId
     * @return Post
     */
    public function getPost($postId) {
        $Post = Kernel::getRepository(EntityType::POST)->loadById($postId);

        return $Post;
    }
}