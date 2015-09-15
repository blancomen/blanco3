<?php
namespace Comment;

use Orm\Entity;
use Orm\Repository\AbstractRepository;

class CommentRepository extends AbstractRepository {

    /**
     * @return string
     */
    protected function getEntityType() {
        return Comment::TYPE;
    }

    /**
     * @param array $data
     * @return Entity
     */
    protected function createEntity(array $data = []) {
        return new Comment($data);
    }
}