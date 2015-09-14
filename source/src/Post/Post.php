<?php
namespace Post;

use Orm\Entity;
use Orm\Entity\LikableEntity;
use Orm\Model\FieldType;

class Post extends LikableEntity {
    const TYPE = 'post';

    const FIELD_USER_ID      = 'user_id';
    const FIELD_CREATE_AT    = 'create_at';
    const FIELD_TITLE        = 'title';
    const FIELD_CONTENT      = 'content';
    const FIELD_COUNTERS     = 'counters';
    const FIELD_PLUSES_USERS = 'pluses_users';

    /**
     * Return config data as array.
     * @see FieldType
     * @return array
     */
    protected function getDataConfig() {
        return array_merge(parent::getDataConfig(), [
            self::FIELD_USER_ID => [
                'type' => FieldType::INT,
            ],
            self::FIELD_CREATE_AT => [
                'type' => FieldType::INT,
            ],
            self::FIELD_TITLE => [
                'type' => FieldType::STRING,
            ],
            self::FIELD_CONTENT => [
                'type' => FieldType::STRING,
            ],
            self::FIELD_COUNTERS => [
                'type' => FieldType::COUNTERS,
            ],
            self::FIELD_PLUSES_USERS => [
                'type' => FieldType::ARR,
            ],
        ]);
    }
}