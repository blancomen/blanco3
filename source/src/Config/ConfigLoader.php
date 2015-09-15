<?php
namespace Config;

use Cache\CacheArray;
use Kernel\Environment;
use Noodlehaus\Config;

class ConfigLoader {
    /**
     * @var Environment
     */
    protected $Environment = null;

    /**
     * @var string
     */
    protected $configFolder = PATH_CONFIG;

    /**
     * @var array
     */
    protected $ConfigCache = null;

    /**
     * @var string
     */
    protected $configExt = '.config.php';

    /**
     * @param Environment $Environment
     */
    public function __construct(Environment $Environment) {
        $this->setEnvironment($Environment);
    }

    /**
     * @return Environment
     */
    public function getEnvironment() {
        return $this->Environment;
    }

    /**
     * @param Environment $Environment
     */
    public function setEnvironment($Environment) {
        $this->Environment = $Environment;
    }

    /**
     * @param string $config
     * @return Config
     */
    public function load($config) {
        $Config = $this->getCache()->find($config);
        if ($Config) {
            return $Config;
        }

        $configPath = $this->getConfigPath($config);
        $Config = new Config($configPath);

        $this->getCache()->set($config, $Config);

        return $Config;
    }

    /**
     * @param string $config
     * @return string
     */
    protected function getConfigPath($config) {
        return $this->getConfigFolder() . DIRECTORY_SEPARATOR . $config . $this->getConfigExt();
    }

    /**
     * @return string
     */
    public function getConfigFolder() {
        return $this->configFolder . DIRECTORY_SEPARATOR . $this->getEnvironment()->get();
    }

    /**
     * @return CacheArray
     */
    protected function getCache() {
        if (is_null($this->ConfigCache)) {
            $this->ConfigCache = new CacheArray();
        }

        return $this->ConfigCache;
    }

    /**
     * @return string
     */
    public function getConfigExt() {
        return $this->configExt;
    }
}