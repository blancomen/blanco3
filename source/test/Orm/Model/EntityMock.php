<?php

use Orm\Entity\FieldParam;
use Orm\Entity\FieldType;
use Orm\Repository\AbstractRepository;

class EntityMock extends \Orm\Entity {
    const TYPE = 'mock';

    const FIELD_A = 'a';
    const FIELD_B = 'b';
    const FIELD_C = 'c';
    const FIELD_D = 'd';
    const FIELD_E = 'e';
    const FIELD_F = 'f';

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
                FieldParam::TYPE => FieldType::INT,
                FieldParam::DEFAULT_VALUE => 100,
            ],
            self::FIELD_B => [
                FieldParam::TYPE => FieldType::STRING,
            ],
            self::FIELD_C => [
                FieldParam::TYPE => FieldType::ARR,
                FieldParam::DEFAULT_VALUE => ['a' => 1, 'b' => 2],
            ],
            self::FIELD_D => [
                FieldParam::TYPE => FieldType::COUNTERS,
            ],
            self::FIELD_E => [
                FieldParam::TYPE => FieldType::FLAGS,
            ],
            self::FIELD_F => [
                FieldParam::TYPE => FieldType::ENTITY,
                FieldParam::ENTITY_TYPE => EntityMock::TYPE,
            ],
        ];
    }

    /**
     * @return string
     */
    public function getType() {
        return self::TYPE;
    }

    /**
     * @var AbstractRepository
     */
    protected $Repository = null;

    public function setRepository(AbstractRepository $Repository) {
        $this->Repository = $Repository;
    }

    /**
     * @return AbstractRepository
     */
    public function getRepository() {
        return $this->Repository;
    }
}