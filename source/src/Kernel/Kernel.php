<?php
namespace Kernel;

use Config\ConfigLoader;
use Connection\ConnectionFactory;

class Kernel {
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
}