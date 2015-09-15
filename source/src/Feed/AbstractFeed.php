<?php
namespace Feed;

use Predis\Client;

abstract class AbstractFeed {
    /**
     * @var Client
     */
    protected $Redis = null;

    /**
     * @param Client $Redis
     */
    public function __construct(Client $Redis) {
        $this->setRedis($Redis);
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


}