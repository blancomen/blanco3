<?php
namespace Kernel;

/**
 * @author yakud
 */
class Environment {
    const LOCAL = 'local';
    const PRODUCTION = 'production';

    /**
     * @param string $environment
     */
    public function __construct($environment) {
        $this->set($environment);
    }

    /**
     * @var string
     */
    protected $environment = null;

    /**
     * @return string
     */
    public function get() {
        return $this->environment;
    }

    /**
     * @param string $environment
     */
    public function set($environment) {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getConfigPath() {
        return PATH_CONFIG . DIRECTORY_SEPARATOR . $this->environment;
    }
}