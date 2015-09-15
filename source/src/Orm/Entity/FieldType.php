<?php
namespace Orm\Entity;

use Orm\Entity;
use Orm\Entity\FieldType\FieldTypeInterface;
use Orm\Entity\FieldType\TypeArray;
use Orm\Entity\FieldType\TypeCounters;
use Orm\Entity\FieldType\TypeEntity;
use Orm\Entity\FieldType\TypeFlags;
use Orm\Entity\FieldType\TypeInt;
use Orm\Entity\FieldType\TypeString;

class FieldType {
    const INT      = 'int';
    const STRING   = 'string';
    const COUNTERS = 'counters';
    const FLAGS    = 'flags';
    const ARR      = 'array';
    const ENTITY   = 'entity';

    /**
     * @param mixed $type
     * @param mixed $value
     * @return array|int|null|string
     */
    public static function serialize($type, $value) {
        return self::getFieldType($type)->serialize($value);
    }

    /**
     * @param string $type
     * @param mixed $value
     * @return mixed
     */
    public static function unserialize($type, $value) {
        return self::getFieldType($type)->unserialize($value);
    }

    /**
     * @param string $type
     * @return array|int|null|Counters|Flags|string
     */
    public static function getDefaultValue($type) {
        return self::getFieldType($type)->getDefaultValue();
    }

    /**
     * @param string $type
     * @return FieldTypeInterface
     * @throws \Exception
     */
    private static function getFieldType($type) {
        switch($type) {
            case FieldType::COUNTERS:
                return new TypeCounters();

            case FieldType::FLAGS:
                return new TypeFlags();

            case FieldType::STRING:
                return new TypeString();

            case FieldType::INT:
                return new TypeInt();

            case FieldType::ARR:
                return new TypeArray();

            case FieldType::ENTITY:
                return new TypeEntity();

            default:
                throw new \Exception("Not found field type {$type}");
        }
    }
}