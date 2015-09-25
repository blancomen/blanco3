<?php
namespace Post;

use Feed\FeedProvider;
use Feed\FeedType;
use Kernel\Kernel;
use Orm\Entity\EntityType;
use User\User;
use Utils\Time;

class PostProvider {
    /**
     * @param User $User
     * @param int $title
     * @param int $content
     * @param array $tags
     * @return Post
     */
    public function createPost(User $User, $title, $content, array $tags = []) {
        $Post = new Post();
        $Post->set(Post::FIELD_USER_OWNER, $User);
        $Post->set(Post::FIELD_TITLE, $title);
        $Post->set(Post::FIELD_CONTENT, $content);
        $Post->set(Post::FIELD_TAGS, $tags);
        $Post->set(Post::FIELD_CREATE_AT, Time::getTime());
        $Post->save();

        $FeedProvider = $this->getFeedProvider();
        $FeedProvider->getFeed(FeedType::MAIN)->savePost($Post);
        $FeedProvider->getFeed(FeedType::USER)->savePost($Post);
        $FeedProvider->getFeed(FeedType::TAG)->savePost($Post);

        return $Post;
    }

    /**
     * @param int $postId
     * @return Post
     */
    public function getPost($postId) {
        $Post = $this->getRepository()->loadById($postId);

        return $Post;
    }

    /**
     * @return PostRepository
     */
    protected function getRepository() {
        return Kernel::getRepository(EntityType::POST);
    }

    /**
     * @return FeedProvider
     */
    protected function getFeedProvider() {
        return Kernel::getInstance()->getFeedProvider();
    }
}