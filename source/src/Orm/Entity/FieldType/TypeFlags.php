<?php
namespace Orm\Entity\FieldType;


use Orm\Entity\Flags;

class TypeFlags implements FieldTypeInterface {

    /**
     * @param Flags $value
     * @return array
     */
    public function serialize($value) {
        return $value->serialize();
    }

    /**
     * @param mixed $value
     * @return Flags
     */
    public function unserialize($value) {
        $Flags = self::getDefaultValue();
        $Flags->unserialize((array) $value);

        return $Flags;
    }

    public function getDefaultValue() {
        return new Flags();
    }


    /**
     * @param mixed $value
     * @return array
     */
    public function export($value) {
        return $this->serialize($value);
    }
}