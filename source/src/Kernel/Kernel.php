<?php
namespace Kernel;

use Config\ConfigLoader;
use Connection\ConnectionFactory;
use Orm\OrmProvider;
use User\UserRepository;

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
     * @var OrmProvider
     */
    protected $OrmProvider = null;

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
     * @return ConnectionFactory
     */
    public function getConnectionFactory() {
        if (is_null($this->ConnectionFactory)) {
            $this->ConnectionFactory = new ConnectionFactory($this->getConfigLoader());
        }

        return $this->ConnectionFactory;
    }

    /**
     * @param OrmProvider $OrmProvider
     */
    public function setOrmProvider($OrmProvider) {
        $this->OrmProvider = $OrmProvider;
    }

    /**
     * @return OrmProvider
     */
    public function getOrmProvider() {
        if (is_null($this->OrmProvider)) {
            $this->OrmProvider = new OrmProvider($this->getConfigLoader(), $this->getConnectionFactory());
        }

        return $this->OrmProvider;
    }
}