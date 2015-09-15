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
     * Find in cache. Return array.
     * If not found element, then return null.
     *
     * @param array $fields
     * @return array
     */
    public function findMany(array $fields) {
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $this->find($field);
        }

        return $data;
    }

    /**
     * @param string $field
     * @param mixed $value
     */
    public function set($field, $value) {
        $this->cache[$field] = $value;
    }

    /**
     * @param array $dictionary
     */
    public function setMany(array $dictionary) {
        $this->cache = array_merge($this->cache, $dictionary);
    }

    public function clear() {
        $this->cache = [];
    }
}