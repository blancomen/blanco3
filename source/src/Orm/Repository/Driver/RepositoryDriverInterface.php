<?php
namespace Orm\Repository\Driver;

use Orm\Repository\EntityNotFoundException;

interface RepositoryDriverInterface {
    /**
     * @param int $id
     * @param string $data
     * @return void
     */
    public function set($id, $data);

    /**
     * @param int $id
     * @return string
     * @throws EntityNotFoundException
     */
    public function get($id);

    /**
     * @param int[] $ids
     * @return string[]
     */
    public function getMany(array $ids);

    /**
     * @return int
     */
    public function getNextId();
}