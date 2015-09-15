<?php
namespace Orm\Provider;

use Orm\Repository\Driver\RepositoryDriverArray;

class OrmProviderArray extends AbstractOrmProvider {
    /**
     * @param $entityType
     * @return mixed
     */
    protected function createRepositoryDriver($entityType) {
        return new RepositoryDriverArray();
    }
}