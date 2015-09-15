<?php
namespace Orm\Entity\FieldType;

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
     * @param mixed $value
     * @return null|Entity
     */
    public function unserialize($value) {
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