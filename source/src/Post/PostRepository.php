<?php
namespace Post;

use Orm\Entity;
use Orm\Repository\AbstractEntityRepository;

class PostRepository extends AbstractEntityRepository {

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