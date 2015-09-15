<?php
namespace Orm;

use Cache\CacheArray;
use Comment\CommentRepository;
use Config\ConfigLoader;
use Connection\ConnectionFactory;
use Exception;
use Orm\Entity\EntityType;
use Orm\Repository\AbstractEntityRepository;
use Post\PostRepository;
use User\UserRepository;

class OrmProvider {
    /**
     * @var CacheArray
     */
    protected $Cache = null;

    /**
     * @var ConfigLoader
     */
    protected $ConfigLoader = null;

    /**
     * @var ConnectionFactory
     */
    protected $ConnectionFactory;

    /**
     * @var string
     */
    protected $configRepositoryRedisName = 'orm/repository-redis';

    /**
     * @param ConfigLoader $ConfigLoader
     * @param ConnectionFactory $ConnectionFactory
     */
    public function __construct(ConfigLoader $ConfigLoader, ConnectionFactory $ConnectionFactory) {
        $this->setConfigLoader($ConfigLoader);
    }

    /**
     * @param string $type
     * @return string
     * @throws Exception
     */
    protected function getRepositoryClassByType($type) {
        switch ($type) {
            case EntityType::USER:
                return UserRepository::class;

            case EntityType::COMMENT:
                return CommentRepository::class;

            case EntityType::POST:
                return PostRepository::class;

            default:
                throw new Exception("Repository for entity type {$type} not found");
        }
    }

    /**
     * @param string $entityType
     * @return AbstractEntityRepository
     */
    public function getRepositoryByType($entityType) {
        $Repository = $this->getCache()->find($entityType);
        if (!is_null($Repository)) {
            return $Repository;
        }

        $redisName = $this->getConfigLoader()->load($this->configRepositoryRedisName);
        $Redis = $this->getConnectionFactory()->getRedis($redisName);

        $class = $this->getRepositoryClassByType($entityType);
        $Repository = new $class($Redis);

        $this->getCache()->set($entityType, $Repository);

        return $Repository;
    }

    /**
     * @return CacheArray
     */
    protected function getCache() {
        if (is_null($this->Cache)) {
            $this->Cache = new CacheArray();
        }

        return $this->Cache;
    }

    /**
     * @return ConfigLoader
     */
    protected function getConfigLoader() {
        return $this->ConfigLoader;
    }

    /**
     * @param ConfigLoader $ConfigLoader
     */
    protected function setConfigLoader(ConfigLoader $ConfigLoader) {
        $this->ConfigLoader = $ConfigLoader;
    }

    /**
     * @return ConnectionFactory
     */
    protected function getConnectionFactory() {
        return $this->ConnectionFactory;
    }

    /**
     * @param ConnectionFactory $ConnectionFactory
     */
    protected function setConnectionFactory(ConnectionFactory $ConnectionFactory) {
        $this->ConnectionFactory = $ConnectionFactory;
    }
}