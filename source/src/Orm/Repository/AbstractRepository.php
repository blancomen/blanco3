<?php
namespace Orm\Repository;

use Cache\CacheArray;
use Orm\Entity;
use Orm\Repository\Driver\RepositoryDriverInterface;

abstract class AbstractRepository {
    /**
     * @var RepositoryDriverInterface
     */
    protected $RepositoryDriver = null;

    /**
     * @var CacheArray
     */
    protected $Cache = null;

    /**
     * @param RepositoryDriverInterface $RepositoryDriver
     */
    public function __construct(RepositoryDriverInterface $RepositoryDriver) {
        $this->setRepositoryDriver($RepositoryDriver);
    }

    /**
     * @return string
     */
    abstract protected function getEntityType();

    /**
     * @param array $data
     * @return Entity
     */
    abstract protected function createEntity(array $data = []);

    /**
     * @param Entity $Entity
     * @return int
     */
    public function save(Entity $Entity) {
        if (!$Entity->getId()) {
            $Entity->setId($this->getNextId());
        }

        $this->getRepositoryDriver()->set($Entity->getId(), $Entity->serialize());
        $this->getCache()->set($Entity->getId(), $Entity);

        return $Entity->getId();
    }

    /**
     * @param int $id
     * @param bool $force
     * @return Entity
     * @throws EntityNotFoundException
     */
    public function loadById($id, $force = false) {
        if (!$force) {
            $Entity = $this->getCache()->find($id);
            if (!is_null($Entity)) {
                return $Entity;
            }
        }

        $data = $this->loadDataById($id);
        $Entity = $this->createEntity($data);

        $this->getCache()->set($Entity->getId(), $Entity);

        return $Entity;
    }

    /**
     * @param int $id
     * @return string
     * @throws EntityNotFoundException
     */
    public function loadDataById($id) {
        return $this->getRepositoryDriver()->get($id);
    }

    /**
     * @param int[] $ids
     * @param bool $force
     * @return \Orm\Entity[]
     */
    public function loadByIds(array $ids, $force = false) {
        $Entities = [];

        if (!$force) {
            // Find in cache
            $Entities = $this->getCache()->findMany($ids);
            $Entities = array_filter($Entities);
        }

        $ids = array_diff($ids, array_keys($Entities));
        if (!sizeof($ids)) {
            return $Entities;
        }

        $dataList = $this->getRepositoryDriver()->getMany($ids);
        foreach ($dataList as $data) {
            $Entity = $this->createEntity($data);
            $Entities[$Entity->getId()] = $Entity;
        }

        $this->getCache()->setMany($Entities);

        return $Entities;
    }

    /**
     * @return int
     */
    protected function getNextId() {
        return $this->getRepositoryDriver()->getNextId();
    }

    /**
     * @return CacheArray
     */
    public function getCache() {
        if (is_null($this->Cache)) {
            $this->Cache = new CacheArray();
        }

        return $this->Cache;
    }

    /**
     * @return RepositoryDriverInterface
     */
    protected function getRepositoryDriver() {
        return $this->RepositoryDriver;
    }

    /**
     * @param RepositoryDriverInterface $RepositoryDriver
     */
    protected function setRepositoryDriver($RepositoryDriver) {
        $this->RepositoryDriver = $RepositoryDriver;
    }
}