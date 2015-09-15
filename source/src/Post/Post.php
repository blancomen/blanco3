<?php
namespace Post;

use Orm\Entity;
use Orm\Entity\EntityType;
use Orm\Entity\FieldParam;
use Orm\Entity\LikableEntity;
use Orm\Entity\FieldType;

class Post extends LikableEntity {
    const TYPE = EntityType::POST;

    const FIELD_USER_ID = 'user_id';
    const FIELD_CREATE_AT = 'create_at';
    const FIELD_TITLE = 'title';
    const FIELD_CONTENT = 'content';
    const FIELD_USER_OWNER = 'user_owner';

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
            self::FIELD_TITLE => [
                FieldParam::TYPE => FieldType::STRING,
            ],
            self::FIELD_CONTENT => [
                FieldParam::TYPE => FieldType::STRING,
            ],
            self::FIELD_USER_OWNER => [
                FieldParam::TYPE => FieldType::ENTITY,
                FieldParam::ENTITY_TYPE => EntityType::USER,
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