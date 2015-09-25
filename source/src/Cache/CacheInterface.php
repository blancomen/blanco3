<?php
namespace Cache;


interface CacheInterface {
    /**
     * @param string $field
     * @return mixed
     */
    public function find($field);

    /**
     * @param string $field
     * @param mixed $value
     */
    public function set($field, $value);

    /**
     * Find in cache. Return array.
     * If not found element, then return null.
     *
     * @param array $fields
     * @return array
     */
    public function findMany(array $fields);

    /**
     * @param array $dictionary
     */
    public function setMany(array $dictionary);

    /**
     * @param mixed $field
     * @return bool
     */
    public function inCache($field);

    /**
     * @return void
     */
    public function clear();
}