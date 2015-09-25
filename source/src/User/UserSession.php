<?php
namespace User;


use Predis\Client;

class UserSession {
    protected $User;
    protected $Client;

    /**
     * @param User $User
     * @param Client $Redis
     */
    public function __construct(User $User, Client $Redis) {
        $this->setUser($User);
        $this->setClient($User);
    }

    protected function getUserSessionId() {
        $key = $this->getKey();
        $session = $this->getRedis()->get($key);

//        $session
    }

    /**
     * @return string
     */
    protected function getKey() {
        return 'session:' . $this->getUser()->getId();
    }

    /**
     *
     */
    public function setSessionId() {

    }

    /**
     * @return User
     */
    protected function getUser() {
        return $this->User;
    }

    /**
     * @param User $User
     */
    protected function setUser(User $User) {
        $this->User = $User;
    }

    /**
     * @return Client
     */
    protected function getRedis() {
        return $this->Client;
    }

    /**
     * @param Client $Client
     */
    protected function setClient(Client $Client) {
        $this->Client = $Client;
    }
}