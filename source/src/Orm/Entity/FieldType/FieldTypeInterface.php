<?php
namespace Orm\Entity\FieldType;


interface FieldTypeInterface {
    public function serialize($value);
    public function unserialize($value);
    public function getDefaultValue();
}