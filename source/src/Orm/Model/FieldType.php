<?php
namespace Orm\Model;

class FieldType {
    const INT      = 'int';
    const STRING   = 'string';
    const COUNTERS = 'counters';
    const FLAGS    = 'flags';
    const ARR      = 'array';

    /**
     * @param mixed $type
     * @param int|string|Counters|Flags|array|null|mixed $value
     * @return array|int|null|string
     */
    public static function serialize($type, $value) {
        switch ($type) {
            case FieldType::COUNTERS:
                return $value->serialize();

            case FieldType::FLAGS:
                return $value->serialize();

            case FieldType::STRING:
                return (string) $value;

            case FieldType::INT:
                return (int) $value;

            case FieldType::ARR:
                return (array) $value;

            default:
                return null;
        }
    }

    /**
     * @param string $type
     * @param mixed $value
     * @return mixed
     */
    public static function unserialize($type, $value) {
        switch ($type) {
            case FieldType::COUNTERS:
                $Counters = self::getDefaultValue($type);
                $Counters->unserialize((array) $value);

                return $Counters;

            case FieldType::FLAGS:
                $Flags = self::getDefaultValue($type);
                $Flags->unserialize((array) $value);

                return $Flags;

            case FieldType::STRING:
                return (string) $value;

            case FieldType::INT:
                return (int) $value;

            case FieldType::ARR:
                return (array) $value;

            default:
                return null;
        }
    }

    /**
     * @param string $type
     * @return array|int|null|Counters|Flags|string
     */
    public static function getDefaultValue($type) {
        switch ($type) {
            case FieldType::COUNTERS:
                return new Counters();

            case FieldType::FLAGS:
                return new Flags();

            case FieldType::STRING:
                return '';

            case FieldType::INT:
                return 0;

            case FieldType::ARR:
                return [];

            default:
                return null;
        }
    }
}