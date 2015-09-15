<?php
namespace Orm\Provider;

use Connection\ConnectionFactory;
use Exception;
use Orm\Entity\EntityType;
use Orm\Repository\Driver\RepositoryDriverRedis;

class OrmProviderRedis extends AbstractOrmProvider {
    /**
     * @var ConnectionFactory
     */
    protected $ConnectionFactory;

    /**
     * @param ConnectionFactory $ConnectionFactory
     */
    public function __construct(ConnectionFactory $ConnectionFactory) {
        $this->setConnectionFactory($ConnectionFactory);
    }

    /**
     * @param $entityType
     * @return mixed
     */
    protected function createRepositoryDriver($entityType) {
        $redisName = $this->getRepositoryRedisName($entityType);
        $Redis = $this->getConnectionFactory()->getRedis($redisName);

        return new RepositoryDriverRedis($entityType, $Redis);
    }

    /**
     * @param string $entityType
     * @return string
     * @throws Exception
     */
    protected function getRepositoryRedisName($entityType) {
        $config = $this->getRepositoryRedisConfig();
        if (!array_key_exists($entityType, $config)) {
            throw new Exception("Not found redis for repository {$entityType}");
        }

        return $config[$entityType];
    }

    /**
     * @return array
     */
    protected function getRepositoryRedisConfig() {
        return [
            EntityType::USER => 'test',
            EntityType::COMMENT => 'test',
            EntityType::POST => 'test',
        ];
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