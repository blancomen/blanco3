<?php
namespace Kernel;


use User\User;

class Application {
    /**
     * @var User
     */
    protected $SessionUser = null;

    /**
     * @param User $User
     */
    public function setSessionUser(User $User) {
        $this->SessionUser = $User;
    }

    /**
     * @return User
     */
    public function getSessionUser() {
        return $this->SessionUser;
    }
}