<?php
namespace Orm\Entity\FieldType;

use Exception;
use Kernel\Kernel;
use Orm\Entity;

class TypeEntity implements FieldTypeInterface {

    /**
     * @param Entity $value
     * @return int
     */
    public function serialize($value) {
        if (!($value instanceof Entity)) {
            return [];
        }

        return [
            'id' => $value->getId(),
            'type' => $value->getType(),
        ];
    }


    /**
     * @param Entity $value
     * @return array
     */
    public function export($value) {
        if (!($value instanceof Entity)) {
            return [];
        }

        return $value->export();
    }

    /**
     * @param mixed $value
     * @return null|Entity
     * @throws Exception
     */
    public function unserialize($value) {
        if ($value instanceof Entity) {
            if (!$value->getId()) {
                throw new Exception("You need set ID for entity");
            }

            return $value;
        }

        if (!is_array($value)) {
            return $this->getDefaultValue();
        }

        if (!array_key_exists('type', $value) || !array_key_exists('id', $value)) {
            return $this->getDefaultValue();
        }

        $Repository = $this->getRepositoryByType($value['type']);
        $Entity = $Repository->loadById($value['id']);

        return $Entity;
    }

    /**
     * @return null
     */
    public function getDefaultValue() {
        return null;
    }

    protected function getRepositoryByType($type) {
        return Kernel::getInstance()->getOrmProvider()->getRepositoryByType($type);
    }
}