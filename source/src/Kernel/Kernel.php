<?php
namespace Kernel;

use Config\ConfigLoader;
use Connection\ConnectionFactory;
use Feed\FeedProvider;
use Orm\Provider\AbstractOrmProvider;

class Kernel {
    /**
     * @var self
     */
    protected static $Instance = null;

    /**
     * @var ConfigLoader
     */
    protected $ConfigLoader = null;

    /**
     * @var Environment
     */
    protected $Environment = null;

    /**
     * @var ConnectionFactory
     */
    protected $ConnectionFactory = null;

    /**
     * @var AbstractOrmProvider
     */
    protected $OrmProvider = null;

    /**
     * @var FeedProvider
     */
    protected $FeedProvider = null;

    /**
     * @param Kernel $Kernel
     */
    public static function setInstance(Kernel $Kernel) {
        self::$Instance = $Kernel;
    }

    /**
     * @return Kernel
     */
    public static function getInstance() {
        return self::$Instance;
    }

    /**
     * @param string $type
     * @return \Orm\Repository\AbstractRepository
     */
    public static function getRepository($type) {
        return self::getInstance()->getOrmProvider()->getRepositoryByType($type);
    }

    /**
     * @param ConfigLoader $ConfigLoader
     */
    public function setConfigLoader(ConfigLoader $ConfigLoader) {
        $this->ConfigLoader = $ConfigLoader;
    }

    /**
     * @return ConfigLoader
     */
    public function getConfigLoader() {
        return $this->ConfigLoader;
    }

    /**
     * @param Environment $Environment
     */
    public function setEnvironment(Environment $Environment) {
        $this->Environment = $Environment;
    }

    /**
     * @return Environment
     */
    public function getEnvironment() {
        return $this->Environment;
    }

    /**
     * @param ConnectionFactory $ConnectionFactory
     */
    public function setConnectionFactory(ConnectionFactory $ConnectionFactory) {
        $this->ConnectionFactory = $ConnectionFactory;
    }

    /**
     * @return ConnectionFactory
     */
    public function getConnectionFactory() {
        return $this->ConnectionFactory;
    }

    /**
     * @param AbstractOrmProvider $OrmProvider
     */
    public function setOrmProvider($OrmProvider) {
        $this->OrmProvider = $OrmProvider;
    }

    /**
     * @return AbstractOrmProvider
     */
    public function getOrmProvider() {
        return $this->OrmProvider;
    }

    /**
     * @return FeedProvider
     */
    public function getFeedProvider() {
        if (is_null($this->FeedProvider)) {
            $this->FeedProvider = new FeedProvider($this->getConnectionFactory());
        }

        return $this->FeedProvider;
    }

    /**
     * @param FeedProvider $FeedProvider
     */
    public function setFeedProvider(FeedProvider $FeedProvider) {
        $this->FeedProvider = $FeedProvider;
    }
}