<?php
namespace User;

use Orm\Entity;
use Orm\Repository\AbstractEntityRepository;

class UserRepository extends AbstractEntityRepository {
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