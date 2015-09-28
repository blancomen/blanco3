<?php
namespace User;

use Orm\Entity;
use Orm\Entity\EntityType;
use Orm\Entity\FieldParam;
use Orm\Entity\LikableEntity;
use Orm\Entity\FieldType;

class User extends LikableEntity {
    const TYPE = EntityType::USER;

    const FIELD_EMAIL    = 'email';
    const FIELD_NAME    = 'name';
    const FIELD_PASSWORD = 'password';
    const FIELD_COUNTERS = 'counters';
    const FIELD_FLAGS    = 'flags';

    const COUNTER_POSTS    = 'posts_counter';
    const COUNTER_COMMENTS = 'comments_counter';
    const COUNTER_CARMA    = 'carma_counter';

    /**
     * Return config data as array.
     * @see FieldType
     * @return array
     */
    protected function getDataConfig() {
        return [
            self::FIELD_EMAIL => [
                FieldParam::TYPE => FieldType::STRING,
            ],
            self::FIELD_NAME => [
                FieldParam::TYPE => FieldType::STRING,
            ],
            self::FIELD_PASSWORD => [
                FieldParam::TYPE => FieldType::STRING,
            ],
            self::FIELD_COUNTERS => [
                FieldParam::TYPE => FieldType::COUNTERS,
            ],
            self::FIELD_FLAGS => [
                FieldParam::TYPE => FieldType::FLAGS,
            ],
        ];
    }

    /**
     * @return string
     */
    public function getType() {
        return self::TYPE;
    }
}