<?php
namespace Feed;

use Cache\CacheArray;
use Connection\ConnectionFactory;
use Exception;
use Kernel\Kernel;

class FeedProvider {
    /**
     * @var CacheArray
     */
    protected $Cache = null;

    /**
     * @var ConnectionFactory
     */
    protected $ConnectionFactory = null;

    /**
     * @param ConnectionFactory $ConnectionFactory
     */
    public function __construct(ConnectionFactory $ConnectionFactory) {
        $this->setConnectionFactory($ConnectionFactory);
    }

    /**
     * @param string $feedType
     * @return FeedMain|FeedTag|FeedUser
     * @throws Exception
     */
    public function getFeed($feedType) {
        $Cache = $this->getCache();

        if ($Cache->inCache($feedType)) {
            return $Cache->find($feedType);
        }

        $Feed = $this->createFeed($feedType);
        $Cache->set($feedType, $Feed);

        return $Feed;
    }

    /**
     * @param string $feedType
     * @return FeedMain|FeedTag|FeedUser
     * @throws Exception
     */
    protected function createFeed($feedType) {
        $Redis = $this->getFeedRedis($feedType);

        switch ($feedType) {
            case FeedType::MAIN:
                return new FeedMain($Redis);

            case FeedType::TAG:
                return new FeedTag($Redis);

            case FeedType::USER:
                return new FeedUser($Redis);

            default:
                throw new Exception("Feed with type {$feedType} not found");
        }
    }

    /**
     * @param string $feedType
     * @return string
     * @throws Exception
     */
    protected function getFeedRedisName($feedType) {
        switch ($feedType) {
            case FeedType::MAIN:
                return 'default';

            case FeedType::TAG:
                return 'default';

            case FeedType::USER:
                return 'default';

            default:
                throw new Exception("Feed with type {$feedType} not found");
        }
    }

    /**
     * @param string $feedType
     * @return \Predis\Client
     */
    protected function getFeedRedis($feedType) {
        $redisName = $this->getFeedRedisName($feedType);
        $Redis = $this->getConnectionFactory()->getRedis($redisName);

        return $Redis;
    }

    /**
     * @return \Connection\ConnectionFactory
     */
    protected function getConnectionFactory() {
        return $this->ConnectionFactory;
    }

    /**
     * @param ConnectionFactory $ConnectionFactory
     */
    public function setConnectionFactory(ConnectionFactory $ConnectionFactory) {
        $this->ConnectionFactory = $ConnectionFactory;
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
}