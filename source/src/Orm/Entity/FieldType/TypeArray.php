<?php
namespace Orm\Entity\FieldType;


class TypeArray implements FieldTypeInterface {

    /**
     * @param string $value
     * @return array
     */
    public function serialize($value) {
        return (array) $value;
    }

    /**
     * @param mixed $value
     * @return array
     */
    public function unserialize($value) {
        return (array) $value;
    }

    public function getDefaultValue() {
        return [];
    }

    /**
     * @param mixed $value
     * @return array
     */
    public function export($value) {
        return $this->serialize($value);
    }
}