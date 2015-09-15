<?php

use Orm\Repository\Driver\RepositoryDriverArray;
use Orm\Repository\EntityNotFoundException;

class RepositoryTest extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        $Rep = $this->createRepository();
        $this->assertInstanceOf(Orm\Repository\AbstractRepository::class, $Rep);
    }

    public function testSaveLoad() {
        $Rep = $this->createRepository();

        $Entity = $this->createEntity();
        $Entity->set(EntityMock::FIELD_A, 9);
        $Entity->set(EntityMock::FIELD_B, 'Hell');
        $Entity->set(EntityMock::FIELD_C, ['this' => 'is', 'super' => 'array']);
        $Entity->getCounters(EntityMock::FIELD_D)->increment('a', 100);
        $Entity->getFlags(EntityMock::FIELD_E)->setBit(1);

        $id = $Rep->save($Entity);
        $this->assertEquals(1, $id);
        $this->assertEquals(1, $Entity->getId());

        $id = $Rep->save($Entity);
        $this->assertEquals(1, $id);
        $this->assertEquals(1, $Entity->getId());

        $LoadedEntity = $Rep->loadById(1);
        $this->assertEquals($Entity, $LoadedEntity);
        $this->assertEquals($Entity->serialize(), $LoadedEntity->serialize());
    }

    public function testLoadByIds() {
        $Rep = $this->createRepository();

        $ids = [];
        $Entities = [];

        $count = 10;
        while ($count--) {
            $Entity = $this->createEntity();
            $Entity->set(EntityMock::FIELD_A, rand(100, 10000));

            $ids[] = $Rep->save($Entity);
            $Entities[$Entity->getId()] = $Entity;
        }

        $LoadedEntities = $Rep->loadByIds($ids);
        $this->assertEquals($ids, array_keys($LoadedEntities));

        foreach ($LoadedEntities as $id => $LoadedEntity) {
            $this->assertEquals($Entities[$id], $LoadedEntity);
        }
    }

    public function testNotFound() {
        $Rep = $this->createRepository();
        $this->setExpectedException(EntityNotFoundException::class);

        $Rep->loadById(100);
    }

    private function createRepository() {
        return new RepositoryMock(new RepositoryDriverArray());
    }

    private function createEntity() {
        return new EntityMock();
    }
}