<?php
namespace Cache;


interface CacheInterface {
    /**
     * @param string $field
     * @return mixed
     */
    public function get($field);

    /**
     * @param string $field
     * @param mixed $value
     */
    public function set($field, $value);
    
    public function clear();
}