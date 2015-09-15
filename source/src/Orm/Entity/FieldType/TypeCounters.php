<?php
namespace Orm\Entity\FieldType;

use Orm\Entity\Counters;

class TypeCounters implements FieldTypeInterface {

    /**
     * @param Counters $value
     * @return mixed
     */
    public function serialize($value) {
        return $value->serialize();
    }

    /**
     * @param mixed $value
     * @return TypeCounters
     */
    public function unserialize($value) {
        $Counters = $this->getDefaultValue();
        $Counters->unserialize((array) $value);

        return $Counters;
    }

    public function getDefaultValue() {
        return new Counters();
    }
}