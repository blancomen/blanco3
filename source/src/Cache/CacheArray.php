<?php
namespace Cache;

/**
 * @author akiselev
 */
class CacheArray implements CacheInterface {
    /**
     * @var array
     */
    protected $cache = [];

    /**
     * @param string $field
     * @return mixed
     */
    public function find($field) {
        return array_key_exists($field, $this->cache) ? $this->cache[$field] : null;
    }

    /**
     * @param string $field
     * @param mixed $value
     */
    public function set($field, $value) {
        $this->cache[$field] = $value;
    }

    public function clear() {
        $this->cache = [];
    }
}