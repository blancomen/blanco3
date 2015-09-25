<?php
namespace Post;

use LogicException;
use Orm\Entity;
use Orm\Entity\EntityType;
use Orm\Entity\FieldParam;
use Orm\Entity\LikableEntity;
use Orm\Entity\FieldType;
use User\User;

class Post extends LikableEntity {
    const TYPE = EntityType::POST;

    const FIELD_CREATE_AT = 'create_at';
    const FIELD_TITLE = 'title';
    const FIELD_CONTENT = 'content';
    const FIELD_USER_OWNER = 'user_owner';
    const FIELD_TAGS = 'tags';

    /**
     * @return User|null
     */
    public function getOwner() {
        return $this->get(self::FIELD_USER_OWNER);
    }

    /**
     * @param User $User
     */
    public function setOwner(User $User) {
        if (!$User->getId()) {
            throw new LogicException("Can not set owner without id");
        }

        $this->set(self::FIELD_USER_OWNER, $User);
    }

    /**
     * Return config data as array.
     * @see FieldType
     * @return array
     */
    protected function getDataConfig() {
        return array_merge(parent::getDataConfig(), [
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
            self::FIELD_TAGS => [
                FieldParam::TYPE => FieldType::ARR,
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