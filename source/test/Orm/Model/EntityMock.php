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
                'type' => \Orm\Entity\FieldType::INT,
                'default' => 100,
            ],
            self::FIELD_B => [
                'type' => \Orm\Entity\FieldType::STRING,
            ],
            self::FIELD_C => [
                'type' => \Orm\Entity\FieldType::ARR,
                'default' => ['a' => 1, 'b' => 2],
            ],
            self::FIELD_D => [
                'type' => \Orm\Entity\FieldType::COUNTERS,
            ],
            self::FIELD_E => [
                'type' => \Orm\Entity\FieldType::FLAGS,
            ],
        ];
    }

    /**
     * @return string
     */
    public function getType() {
        return 'mock';
    }
}