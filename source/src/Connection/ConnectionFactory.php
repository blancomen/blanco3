<?php
namespace Connection;

use Config\ConfigLoader;
use Exception;
use Predis\Client;

class ConnectionFactory {
    const TYPE_REDIS = 'redis';

    /**
     * @var ConfigLoader
     */
    protected $ConfigLoader = null;

    /**
     * @var string
     */
    protected $configFolder = 'connection';

    /**
     * @param ConfigLoader $ConfigLoader
     */
    public function __construct(ConfigLoader $ConfigLoader) {
        $this->setConfigLoader($ConfigLoader);
    }

    /**
     * @param string $name
     * @return Client
     */
    public function getRedis($name) {
        /** @var Client $Client */
        $Client = $this->getClient(self::TYPE_REDIS, $name);
        $Client->connect();

        return $Client;
    }

    /**
     * @param string $clientType
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    protected function getClient($clientType, $name) {
        $connectionConfig = $this->getConnectionConfig($clientType, $name);

        switch ($clientType) {
            case self::TYPE_REDIS:
                return new Client($connectionConfig);

            default:
                throw new Exception("Not found client type: {$clientType}");
        }
    }

    /**
     * @param string $clientType
     * @param string $name
     * @return array|mixed|null
     */
    public function getConnectionConfig($clientType, $name) {
        $path   = $this->getConnectionConfigPath($clientType);
        $Config = $this->getConfigLoader()->load($path);

        return $Config->get($name);
    }

    /**
     * @param string $clientType
     * @return string
     */
    protected function getConnectionConfigPath($clientType) {
        return $this->getConfigFolder() . DIRECTORY_SEPARATOR . $clientType;
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
    protected function setConfigLoader($ConfigLoader) {
        $this->ConfigLoader = $ConfigLoader;
    }

    /**
     * @return string
     */
    protected function getConfigFolder() {
        return $this->configFolder;
    }
}