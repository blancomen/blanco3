<?php
namespace Post;

use Orm\Entity;
use Orm\Repository\AbstractRepository;

class PostRepository extends AbstractRepository {

    /**
     * @return string
     */
    protected function getEntityType() {
        return Post::TYPE;
    }

    /**
     * @param array $data
     * @return Entity
     */
    protected function createEntity(array $data = []) {
        return new Post($data);
    }
}