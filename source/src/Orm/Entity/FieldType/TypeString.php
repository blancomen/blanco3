<?php
namespace Orm\Entity\FieldType;


class TypeString implements FieldTypeInterface {

    /**
     * @param mixed $value
     * @return string
     */
    public function serialize($value) {
        return (string) $value;
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function unserialize($value) {
        return (string) $value;
    }

    /**
     * @return string
     */
    public function getDefaultValue() {
        return '';
    }

    /**
     * @param mixed $value
     * @return array
     */
    public function export($value) {
        return $this->serialize($value);
    }
}