<?php

class EntityMock extends \Orm\Entity {

    const FIELD_A = 'a';
    const FIELD_B = 'b';
    const FIELD_C = 'c';
    const FIELD_D = 'd';
    const FIELD_E = 'e';

    /**
     * Return config data as array.
     * Example:
     * <code>
     * return [
     *   'a' => [
     *     'type' => FieldType::INT,
     *     'default' => 0,
     *   ],
     *   'b' => [
     *     'type' => FieldType::STRING,
     *     'default' => 'Hello',
     *   ],
     * ];
     * </code>
     *
     * @see FieldType
     * @return array
     */
    protected function getDataConfig() {
        return [
            self::FIELD_A => [
                'type' => \Orm\Model\FieldType::INT,
                'default' => 100,
            ],
            self::FIELD_B => [
                'type' => \Orm\Model\FieldType::STRING,
            ],
            self::FIELD_C => [
                'type' => \Orm\Model\FieldType::ARR,
                'default' => ['a' => 1, 'b' => 2],
            ],
            self::FIELD_D => [
                'type' => \Orm\Model\FieldType::COUNTERS,
            ],
            self::FIELD_E => [
                'type' => \Orm\Model\FieldType::FLAGS,
            ],
        ];
    }
}