<?php
namespace Orm\Repository\Driver;

use Orm\Repository\EntityNotFoundException;
use Predis\Client;

class RepositoryDriverRedis implements RepositoryDriverInterface {
    /**
     * @var Client
     */
    protected $Redis = null;

    /**
     * @var string
     */
    private $containerName = '';

    /**
     * @param string $containerName
     * @param Client $Redis
     */
    public function __construct($containerName, Client $Redis) {
        $this->setContainerName($containerName);
        $this->setRedis($Redis);
    }

    /**
     * @param int $id
     * @param string $data
     * @return void
     */
    public function set($id, $data) {
        $jsonData = json_encode($data);
        $this->getRedis()->hset($this->getContainerName(), $id, $jsonData);
    }

    /**
     * @param int $id
     * @return string
     * @throws EntityNotFoundException
     */
    public function get($id) {
        $containerName = $this->getContainerName();
        $jsonData = $this->getRedis()->hget($containerName, $id);

        if (!$jsonData) {
            throw new EntityNotFoundException("Entity id {$id} not found at container {$containerName}");
        }

        $data = json_decode($jsonData, true);

        return $data;
    }

    /**
     * @param int[] $ids
     * @return string[]
     */
    public function getMany(array $ids) {
        $containerName = $this->getContainerName();
        $jsonDataList = $this->getRedis()->hmget($containerName, $ids);

        $data = [];
        foreach ($jsonDataList as $jsonData) {
            $data[] = json_decode($jsonData, true);
        }

        return $data;
    }

    /**
     * @return int
     */
    public function getNextId() {
        $counterName = $this->getContainerName() . ':counter_id';
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
    protected function setRedis(Client $Redis) {
        $this->Redis = $Redis;
    }

    /**
     * @return string
     */
    public function getContainerName() {
        return $this->containerName;
    }

    /**
     * @param string $containerName
     */
    public function setContainerName($containerName) {
        $this->containerName = $containerName;
    }
}