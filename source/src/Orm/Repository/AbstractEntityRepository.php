<?php
namespace Orm\Repository;

use Cache\CacheArray;
use Orm\Entity;
use Predis\Client;

abstract class AbstractEntityRepository {
    /**
     * @var Client
     */
    protected $Redis = null;

    /**
     * @var CacheArray
     */
    protected $Cache = null;

    /**
     * @param Client $Redis
     */
    public function __construct(Client $Redis) {
        $this->setRedis($Redis);
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

        $data = $Entity->serialize();
        $jsonData = json_encode($data);

        $this->set($Entity->getId(), $jsonData);
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
        $jsonData = null;

        if (!$force) {
            $jsonData = $this->getCache()->find($id);
        }

        if (!$jsonData) {
            $jsonData = $this->get($id);
        }

        $data = json_decode($jsonData, true);
        $Entity = $this->createEntity($data);

        $this->getCache()->set($Entity->getId(), $Entity);

        return $Entity;
    }

    /**
     * @param int[] $ids
     * @return Entity[]
     */
    public function loadByIds(array $ids) {
        $listJsonData = $this->mget($ids);

        $Entities = [];
        foreach ($listJsonData as $jsonData) {
            $data = json_decode($jsonData, true);
            $Entity = $this->createEntity($data);

            $this->getCache()->set($Entity->getId(), $Entity);

            $Entities[$Entity->getId()] = $Entity;
        }

        return $Entities;
    }

    /**
     * @param int $id
     * @param mixed $data
     */
    protected function set($id, $data) {
        $this->getRedis()->hset($this->getEntityType(), $id, $data);
    }

    /**
     * @param int $id
     * @return string
     * @throws EntityNotFoundException
     */
    protected function get($id) {
        $type = $this->getEntityType();
        $data = $this->getRedis()->hget($type, $id);

        if (!$data) {
            throw new EntityNotFoundException("Entity {$type} with id {$id} not found");
        }

        return $data;
    }

    /**
     * @param array $ids
     * @return array
     */
    protected function mget(array $ids) {
        $type = $this->getEntityType();
        $listJsonData = $this->getRedis()->hmget($type, $ids);

        return $listJsonData;
    }

    /**
     * @return int
     */
    protected function getNextId() {
        $counterName = $this->getEntityType() . ':counter_id';
        return $this->getRedis()->incrby($counterName, 1);
    }

    /**
     * @return Client
     */
    protected function getRedis() {
        return $this->Redis;
    }

    /**
     * @param Client $Redis
     */
    protected function setRedis($Redis) {
        $this->Redis = $Redis;
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
}