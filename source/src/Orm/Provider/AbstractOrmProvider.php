<?php
namespace Orm\Provider;

use Cache\CacheArray;
use Comment\CommentRepository;
use Exception;
use Feed\FeedProvider;
use Orm\Entity\EntityType;
use Orm\Repository\AbstractRepository;
use Orm\Repository\Driver\RepositoryDriverInterface;
use Post\PostRepository;
use User\UserRepository;

abstract class AbstractOrmProvider {
    /**
     * @var CacheArray
     */
    protected $Cache = null;

    /**
     * @param string $entityType
     * @return RepositoryDriverInterface
     */
    abstract protected function createRepositoryDriver($entityType);

    /**
     * @param string $entityType
     * @return AbstractRepository
     */
    public function getRepositoryByType($entityType) {
        $Cache = $this->getCache();

        if ($Cache->inCache($entityType)) {
            return $Cache->find($entityType);
        }

        $RepositoryDriver = $this->createRepositoryDriver($entityType);
        $Repository = $this->createRepository($entityType, $RepositoryDriver);

        $Cache->set($entityType, $Repository);

        return $Repository;
    }

    /**
     * @param string $type
     * @param RepositoryDriverInterface $RepositoryDriver
     * @return string
     * @throws Exception
     */
    protected function createRepository($type, RepositoryDriverInterface $RepositoryDriver) {
        switch ($type) {
            case EntityType::USER:
                return new UserRepository($RepositoryDriver);

            case EntityType::COMMENT:
                return new CommentRepository($RepositoryDriver);

            case EntityType::POST:
                return new PostRepository($RepositoryDriver);

            default:
                throw new Exception("Repository for entity type {$type} not found");
        }
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