<?php
namespace Feed;

use Kernel\Kernel;
use Orm\Entity\EntityType;
use Orm\Repository\AbstractRepository;
use Post\Post;

class FeedMain extends AbstractFeed {
    public function savePost(Post $Post) {
        $this->getRedis()->zadd($this->getFeedName(), [
            $Post->getId() => $Post->get(Post::FIELD_CREATE_AT),
        ]);
    }

    /**
     * @param $fromTime
     * @param $offset
     * @param $count
     * @return Post[]
     */
    public function getPosts($fromTime, $offset, $count) {
        $postIds = $this->getRedis()->zrevrangebyscore(
            $this->getFeedName(),
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
     * @return string
     */
    protected function getFeedName() {
        return 'main';
    }
}