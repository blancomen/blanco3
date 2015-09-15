<?php

class FlagsTest extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        $Flags = $this->createFlags();
        $this->assertInstanceOf(\Orm\Entity\Flags::class, $Flags);
    }

    public function testSetIsSetBit() {
        $Flags = $this->createFlags();

        $Flags->setBit(0);
        $Flags->setBit(1);
        $Flags->setBit(1000);

        $this->assertTrue($Flags->isBitSet(0));
        $this->assertTrue($Flags->isBitSet(1));
        $this->assertTrue($Flags->isBitSet(1000));
        $this->assertFalse($Flags->isBitSet(100000));
    }

    public function testUnsetBit() {
        $Flags = $this->createFlags();

        $Flags->setBit(0);
        $Flags->setBit(1);
        $Flags->setBit(1000);
        $Flags->unsetBit(0);
        $Flags->unsetBit(1000);

        $this->assertFalse($Flags->isBitSet(0));
        $this->assertFalse($Flags->isBitSet(1000));
        $this->assertTrue($Flags->isBitSet(1));
    }

    public function testSerializeUnserialize() {
        $Flags = $this->createFlags();

        $Flags->setBit(0);
        $Flags->setBit(1);
        $Flags->setBit(10000);

        $data = $Flags->serialize();
        $UnserizlizeFlags = $this->createFlags();
        $UnserizlizeFlags->unserialize($data);

        $this->assertEquals($Flags, $UnserizlizeFlags);
        $this->assertEquals($data, $UnserizlizeFlags->serialize());
    }

    private function createFlags() {
        return new \Orm\Entity\Flags();
    }
}