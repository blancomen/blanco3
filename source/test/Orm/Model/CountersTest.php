<?php

class CountersTest extends PHPUnit_Framework_TestCase {
    public function testSimple() {
        $Counters = $this->createCounters();
        $this->assertInstanceOf(\Orm\Entity\Counters::class, $Counters);
    }

    public function testGetSet() {
        $Counters = $this->createCounters();

        $this->assertEquals(0, $Counters->get('a'));

        $Counters->set('a', 10);
        $this->assertEquals(10, $Counters->get('a'));

        $Counters->set('a', 20);
        $this->assertEquals(20, $Counters->get('a'));
    }

    public function testIncrement() {
        $Counters = $this->createCounters();

        $this->assertEquals(1,  $Counters->increment('a'));
        $this->assertEquals(11, $Counters->increment('a', 10));
        $this->assertEquals(10, $Counters->increment('b', 10));
    }

    public function testDecrement() {
        $Counters = $this->createCounters();

        $this->assertEquals(-1,  $Counters->decrement('a'));
        $this->assertEquals(-11, $Counters->decrement('a', 10));
        $this->assertEquals(-10, $Counters->decrement('b', 10));
    }

    public function testSerializeUnserialize() {
        $Counters = $this->createCounters();

        $Counters->increment('a', 10);
        $Counters->increment('b', 20);
        $data = $Counters->serialize();

        $this->assertEquals([
            'a' => 10,
            'b' => 20,
        ], $data);

        $UnserializedCounters = $this->createCounters();
        $UnserializedCounters->unserialize($data);

        $this->assertEquals($Counters, $UnserializedCounters);
        $this->assertEquals($data, $UnserializedCounters->serialize());
    }

    private function createCounters() {
        return new \Orm\Entity\Counters();
    }
}