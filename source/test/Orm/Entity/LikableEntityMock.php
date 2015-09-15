<?php
use Orm\Entity\LikableEntity;

class LikableEntityMock extends LikableEntity {

    /**
     * @return string
     */
    public function getType() {
        return 'mock';
    }
}