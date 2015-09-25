<?php
namespace Feed;

use Kernel\Kernel;
use Orm\Entity\EntityType;
use Orm\Repository\AbstractRepository;
use Post\Post;

class FeedUser extends AbstractFeed {
    /**
     * @param Post $Post
     */
    public function savePost(Post $Post) {
        $ownerId = $Post->getOwner()->getId();

        $this->getRedis()->zadd($this->getFeedName($ownerId), [
            $Post->getId() => $Post->get(Post::FIELD_CREATE_AT),
        ]);
    }

    /**
     * @param $ownerId
     * @param $fromTime
     * @param $offset
     * @param $count
     * @return \Post\Post[]
     */
    public function getPosts($ownerId, $fromTime, $offset, $count) {
        $postIds = $this->getRedis()->zrevrangebyscore(
            $this->getFeedName($ownerId),
            $fromTime,
            '-inf',
            [
                'limit' => [$offset, $count],
            ]
        );

        $Posts = $this->getPostRepository()->loadByIds($postIds);

        return $Posts;
    }

    /**
     * @return AbstractRepository
     */
    protected function getPostRepository() {
        return Kernel::getInstance()->getOrmProvider()->getRepositoryByType(EntityType::POST);
    }

    /**
    * @param string $context
    * @return string
    */
    protected function getFeedName($context = null) {
        return 'feed:user:' . $context;
    }
}