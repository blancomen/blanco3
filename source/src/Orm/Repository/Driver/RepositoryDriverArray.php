<?php
namespace Orm\Repository\Driver;

use Orm\Repository\EntityNotFoundException;

class RepositoryDriverArray implements RepositoryDriverInterface {
    private $id = 0;
    private $data = [];

    /**
     * @param int $id
     * @param string $data
     * @return void
     */
    public function set($id, $data) {
        $this->data[$id] = $data;
    }

    /**
     * @param int $id
     * @return string
     * @throws EntityNotFoundException
     */
    public function get($id) {
        if (!array_key_exists($id, $this->data)) {
            throw new EntityNotFoundException("Entity with id {$id} not found");
        }

        return $this->data[$id];
    }

    /**
     * @param int[] $ids
     * @return string[]
     */
    public function getMany(array $ids) {
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
    public function getNextId() {
        return ++$this->id;
    }
}