<?php

use Orm\Entity;

class EntityTest extends PHPUnit_Framework_TestCase {
    public function testSimple() {
        $Entity = $this->createEntityMock();
        $this->assertInstanceOf(Entity::class, $Entity);
    }

    public function testSetGet() {
        $Entity = $this->createEntityMock();
        $Entity->set(EntityMock::FIELD_A, 300);
        $Entity->set(EntityMock::FIELD_B, 200);

        $this->assertEquals(300, $Entity->get(EntityMock::FIELD_A));
        $this->assertEquals(200, $Entity->get(EntityMock::FIELD_B));
    }

    public function testDefaultValue() {
        $Entity = $this->createEntityMock();

        $this->assertEquals(100, $Entity->get(EntityMock::FIELD_A));
        $this->assertEquals('', $Entity->get(EntityMock::FIELD_B));
        $this->assertEquals(['a' => 1, 'b' => 2], $Entity->get(EntityMock::FIELD_C));
        $this->assertInstanceOf(\Orm\Entity\Counters::class, $Entity->get(EntityMock::FIELD_D));
        $this->assertInstanceOf(\Orm\Entity\Flags::class, $Entity->get(EntityMock::FIELD_E));
    }

    public function testGetCounters() {
        $Entity = $this->createEntityMock();
        $Counters = $Entity->getCounters(EntityMock::FIELD_D);

        $this->assertInstanceOf(\Orm\Entity\Counters::class, $Counters);
    }

    public function testGetFlags() {
        $Entity = $this->createEntityMock();
        $Flags = $Entity->getFlags(EntityMock::FIELD_E);

        $this->assertInstanceOf(\Orm\Entity\Flags::class, $Flags);
    }

    public function testSerializeUnserialize() {
        $Entity = $this->createEntityMock();
        $Entity->set(EntityMock::FIELD_A, 9);
        $Entity->set(EntityMock::FIELD_B, 'Hell');
        $Entity->set(EntityMock::FIELD_C, ['this' => 'is', 'super' => 'array']);
        $Entity->getCounters(EntityMock::FIELD_D)->increment('a', 100);
        $Entity->getFlags(EntityMock::FIELD_E)->setBit(1);

        $entityData = $Entity->serialize();

        $this->assertEquals(array (
            'a' => 9,
            'b' => 'Hell',
            'c' => array (
                'this' => 'is',
                'super' => 'array',
            ),
            'd' => array (
                'a' => 100,
            ),
            'e' => array (
                0 => 2,
            ),
        ), $entityData);

        $UnserializeEntity = $this->createEntityMock();
        $UnserializeEntity->unserialize($entityData);

        $this->assertEquals($Entity, $UnserializeEntity);
        $this->assertEquals($entityData, $UnserializeEntity->serialize());
    }

    public function testGetIdSetId() {
        $Entity = $this->createEntityMock();
        $Entity->setId(1);

        $this->assertEquals(1, $Entity->getId());
        $this->assertEquals(1, $Entity->get(Entity::FIELD_ID));
    }

    /**
     * @return EntityMock
     */
    private function createEntityMock() {
        return new EntityMock();
    }
}