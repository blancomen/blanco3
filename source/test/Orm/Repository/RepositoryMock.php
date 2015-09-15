<?php

use Orm\Repository\AbstractRepository;

class RepositoryMock extends AbstractRepository {
    /**
     * @return string
     */
    protected function getEntityType() {
        return EntityMock::TYPE;
    }

    /**
     * @param array $data
     * @return \Orm\Entity
     */
    protected function createEntity(array $data = []) {
        return new EntityMock($data);
    }
}