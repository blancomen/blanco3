<?php
namespace User;

use Orm\Entity;
use Orm\Model\FieldType;

class User extends Entity {
    const TYPE = 'user';

    const FIELD_EMAIL    = 'email';
    const FIELD_LOGIN    = 'login';
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
                'type' => FieldType::STRING,
            ],
            self::FIELD_LOGIN => [
                'type' => FieldType::STRING,
            ],
            self::FIELD_PASSWORD => [
                'type' => FieldType::STRING,
            ],
            self::FIELD_COUNTERS => [
                'type' => FieldType::COUNTERS,
            ],
            self::FIELD_FLAGS => [
                'type' => FieldType::FLAGS,
            ],
        ];
    }
}