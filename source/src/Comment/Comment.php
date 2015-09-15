<?php
namespace Comment;

use Orm\Entity;
use Orm\Entity\EntityType;
use Orm\Entity\FieldParam;
use Orm\Entity\LikableEntity;
use Orm\Entity\FieldType;

class Comment extends LikableEntity {
    const TYPE = EntityType::COMMENT;

    const FIELD_USER_ID      = 'user_id';
    const FIELD_CREATE_AT    = 'create_at';
    const FIELD_CONTENT      = 'content';

    /**
     * Return config data as array.
     * @see FieldType
     * @return array
     */
    protected function getDataConfig() {
        return array_merge(parent::getDataConfig(), [
            self::FIELD_USER_ID => [
                FieldParam::TYPE => FieldType::INT,
            ],
            self::FIELD_CREATE_AT => [
                FieldParam::TYPE => FieldType::INT,
            ],
            self::FIELD_CONTENT => [
                FieldParam::TYPE => FieldType::STRING,
            ],
        ]);
    }

    /**
     * @return string
     */
    public function getType() {
        return self::TYPE;
    }
}