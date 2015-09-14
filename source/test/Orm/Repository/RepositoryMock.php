<?php
use Orm\Repository\EntityNotFoundException;

class RepositoryMock extends \Orm\Repository\AbstractEntityRepository {

    private $id = 0;
    private $data = [];

    public function __construct() {}

    /**
     * @return string
     */
    protected function getEntityType() {
        return 'mock';
    }

    /**
     * @param array $data
     * @return \Orm\Entity
     */
    protected function createEntity(array $data = []) {
        return new EntityMock($data);
    }

    /**
     * @param int $id
     * @param mixed $data
     */
    protected function set($id, $data) {
        $this->data[$id] = $data;
    }

    /**
     * @param int $id
     * @return string
     * @throws EntityNotFoundException
     */
    protected function get($id) {
        $type = $this->getEntityType();
        if (!array_key_exists($id, $this->data)) {
            throw new EntityNotFoundException("Entity {$type} with id {$id} not found");
        }

        return $this->data[$id];
    }

    /**
     * @param array $ids
     * @return array
     */
    protected function mget(array $ids) {
        $data = [];
        foreach ($ids as $id) {
            if (!array_key_exists($id, $this->data)) {
                continue;
            }

            $data[$id] = $this->get($id);
        }

        return $data;
    }

    /**
     * @return int
     */
    protected function getNextId() {
        return ++$this->id;
    }
}