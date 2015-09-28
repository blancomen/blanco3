<?php
namespace Orm\Entity\FieldType;


class TypeInt implements FieldTypeInterface {

    /**
     * @param mixed $value
     * @return int
     */
    public function serialize($value) {
        return (int) $value;
    }

    /**
     * @param mixed $value
     * @return int
     */
    public function unserialize($value) {
        return (int) $value;
    }

    /**
     * @return int
     */
    public function getDefaultValue() {
        return 0;
    }


    /**
     * @param mixed $value
     * @return array
     */
    public function export($value) {
        return $this->serialize($value);
    }
}