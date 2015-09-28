<?php
namespace Feed;

use Kernel\Kernel;
use Orm\Entity\EntityType;
use Orm\Repository\AbstractRepository;
use Post\Post;

class FeedTag extends AbstractFeed {
    /**
     * @param Post $Post
     */
    public function savePost(Post $Post) {
        $tags = $Post->get(Post::FIELD_TAGS);

        foreach ($tags as $tag) {
            $this->getRedis()->zadd($this->getFeedName($tag), [
                $Post->getId() => $Post->get(Post::FIELD_CREATE_AT),
            ]);
        }
    }

    /**
     * @param string $tag
     * @param int $fromTime
     * @param int $offset
     * @param int $count
     * @return \Post\Post[]
     */
    public function getPosts($tag, $fromTime, $offset, $count) {
        $postIds = $this->getRedis()->zrevrangebyscore(
            $this->getFeedName($tag),
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
        return 'feed:tag:' . $context;
    }
}