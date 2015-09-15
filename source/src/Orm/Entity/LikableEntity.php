<?php
namespace Orm\Entity;

use LogicException;
use Orm\Entity;
use User\User;

abstract class LikableEntity extends Entity {
    const FIELD_LIKES_COUNTER = 'likes_counter';
    const FIELD_USERS_LIKE    = 'users_like';
    const FIELD_USERS_DISLIKE = 'users_dislike';

    const COUNTER_LIKE    = 'like';
    const COUNTER_DISLIKE = 'dislike';

    /**
     * Return config data as array.
     * @see FieldType
     * @return array
     */
    protected function getDataConfig() {
        return [
            self::FIELD_LIKES_COUNTER => [
                'type' => FieldType::COUNTERS,
            ],
            self::FIELD_USERS_LIKE => [
                'type' => FieldType::ARR,
            ],
            self::FIELD_USERS_DISLIKE => [
                'type' => FieldType::ARR,
            ],
        ];
    }

    /**
     * Can user like entity?
     * @param User $User
     * @return bool
     */
    public function canUserLikeOrDislike(User $User) {
        $userId = $User->getId();
        $whoLiked = $this->getLikedUsersIds();
        $whoDisliked = $this->getDislikedUsersIds();

        return !array_key_exists($userId, $whoLiked) && !array_key_exists($userId, $whoDisliked);
    }

    /**
     * @param User $User
     * @return bool
     */
    public function setUserLike(User $User) {
        if (!$this->canUserLikeOrDislike($User)) {
            throw new LogicException("User {$User->getId()} can not like or dislike this entity");
        }

        $this->addLikeUserId($User->getId());
        $this->getLikesCounter()->increment(self::COUNTER_LIKE);

        // todo User owner karma

        return true;
    }

    /**
     * @param User $User
     * @return bool
     */
    public function setUserDislike(User $User) {
        if (!$this->canUserLikeOrDislike($User)) {
            throw new LogicException("User {$User->getId()} can not like or dislike this entity");
        }

        $this->addDislikeUserId($User->getId());
        $this->getLikesCounter()->increment(self::COUNTER_DISLIKE);

        // todo User owner karma

        return true;
    }

    /**
     * List ids, who liked this entity
     * @return array
     */
    public function getLikedUsersIds() {
        return (array) $this->get(self::FIELD_USERS_LIKE);
    }

    /**
     * List ids, who disliked this entity
     * @return array
     */
    public function getDislikedUsersIds() {
        return (array) $this->get(self::FIELD_USERS_DISLIKE);
    }

    /**
     * @return int
     */
    public function getCountLikes() {
        return $this->getLikesCounter()->get(self::COUNTER_LIKE);
    }

    /**
     * @return int
     */
    public function getCountDislikes() {
        return $this->getLikesCounter()->get(self::COUNTER_DISLIKE);
    }

    /**
     * @return int
     */
    public function getKarma() {
        return $this->getCountLikes() - $this->getCountDislikes();
    }

    /**
     * @return Counters
     */
    protected function getLikesCounter() {
        return $this->get(self::FIELD_LIKES_COUNTER);
    }

    /**
     * @param int $userId
     */
    protected function addLikeUserId($userId) {
        $whoLiked = $this->getLikedUsersIds();
        $whoLiked[$userId] = 1;
        $this->set(self::FIELD_USERS_LIKE, $whoLiked);
    }

    /**
     * @param int $userId
     */
    protected function addDislikeUserId($userId) {
        $whoDisliked = $this->getDislikedUsersIds();
        $whoDisliked[$userId] = 1;
        $this->set(self::FIELD_USERS_DISLIKE, $whoDisliked);
    }
}