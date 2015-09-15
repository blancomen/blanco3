<?php

class LikableEntityTest extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        $Entity = $this->createLikableEntity();
        $this->assertInstanceOf(\Orm\Entity\LikableEntity::class, $Entity);
    }

    public function testLike() {
        $Entity = $this->createLikableEntity();
        $User = $this->createUser(1);

        $Entity->setUserLike($User);
        $this->assertEquals(1, $Entity->getCountLikes());
    }

    public function testDislike() {
        $Entity = $this->createLikableEntity();
        $User = $this->createUser(1);

        $Entity->setUserDislike($User);
        $this->assertEquals(1, $Entity->getCountDislikes());
    }

    public function testGetCountLikes() {
        $Entity = $this->createLikableEntity();
        $User[1] = $this->createUser(1);
        $User[2] = $this->createUser(2);
        $User[3] = $this->createUser(3);

        $Entity->setUserLike($User[1]);
        $Entity->setUserLike($User[2]);
        $Entity->setUserLike($User[3]);

        $this->assertEquals(3, $Entity->getCountLikes());
    }

    public function testGetCountDislikes() {
        $Entity = $this->createLikableEntity();
        $User[1] = $this->createUser(1);
        $User[2] = $this->createUser(2);
        $User[3] = $this->createUser(3);

        $Entity->setUserDislike($User[1]);
        $Entity->setUserDislike($User[2]);
        $Entity->setUserDislike($User[3]);

        $this->assertEquals(3, $Entity->getCountDislikes());
    }

    public function testGetKarma() {
        $Entity = $this->createLikableEntity();
        $User[1] = $this->createUser(1);
        $User[2] = $this->createUser(2);
        $User[3] = $this->createUser(3);

        $Entity->setUserDislike($User[1]);
        $Entity->setUserDislike($User[2]);
        $Entity->setUserLike($User[3]);

        $this->assertEquals(-1, $Entity->getKarma());
    }

    public function testCanUserLikeOrDislike() {
        $Entity = $this->createLikableEntity();
        $User = $this->createUser(1);

        $this->assertTrue($Entity->canUserLikeOrDislike($User));
        $Entity->setUserLike($User);
        $this->assertFalse($Entity->canUserLikeOrDislike($User));
    }

    public function testGetLikedAndDislikedUsersIds() {
        $Entity = $this->createLikableEntity();
        $User[1] = $this->createUser(1);
        $User[2] = $this->createUser(2);
        $User[3] = $this->createUser(3);

        $Entity->setUserLike($User[1]);
        $Entity->setUserLike($User[2]);
        $Entity->setUserDislike($User[3]);

        $this->assertEquals([1=>1,2=>1], $Entity->getLikedUsersIds());
        $this->assertEquals([3=>1], $Entity->getDislikedUsersIds());
    }

    public function testErrorLikeAgain() {
        $Entity = $this->createLikableEntity();
        $User = $this->createUser(1);

        $this->setExpectedException(LogicException::class);

        $Entity->setUserLike($User);
        $Entity->setUserLike($User);
    }

    private function createLikableEntity() {
        return new LikableEntityMock();
    }

    private function createUser($id) {
        return new \User\User([
            \Orm\Entity::FIELD_ID => $id
        ]);
    }
}