<?php
namespace User;

use Orm\Entity;
use Orm\Repository\AbstractRepository;

class UserRepository extends AbstractRepository {
    const REDIS_NAME = 'users';

    /**
     * @return string
     */
    protected function getEntityType() {
        return User::TYPE;
    }

    /**
     * @param array $data
     * @return Entity
     */
    protected function createEntity(array $data = []) {
        return new User($data);
    }
}