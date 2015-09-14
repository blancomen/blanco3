<?php
namespace Orm\Model;

class Counters {
    const DEFAULT_COUNTER_VALUE = 0;

    /**
     * @var array
     */
    protected $counters = [];

    /**
     * @param string $counter
     * @param int $value
     * @return int
     */
    public function increment($counter, $value = 1) {
        return $this->set($counter, $this->get($counter) + $value);
    }

    /**
     * @param string $counter
     * @param int $value
     * @return int
     */
    public function decrement($counter, $value = 1) {
        return $this->increment($counter, -$value);
    }

    /**
     * @param string $counter
     * @return int
     */
    public function get($counter) {
        if (!array_key_exists($counter, $this->counters)) {
            $this->set($counter, self::DEFAULT_COUNTER_VALUE);
        }

        return $this->counters[$counter];
    }

    /**
     * @param string $counter
     * @param int $value
     * @return int
     */
    public function set($counter, $value) {
        return $this->counters[$counter] = $value;
    }

    /**
     * @return array
     */
    public function serialize() {
        return $this->counters;
    }

    /**
     * @param array $serialized
     */
    public function unserialize($serialized) {
        $this->counters = (array) $serialized;
    }
}