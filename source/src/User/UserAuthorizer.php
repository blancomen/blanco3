<?php
namespace User;

use Exception;
use Kernel\Kernel;
use Orm\Entity\EntityType;
use Predis\Client;

class UserAuthorizer {

    /**
     * @var Client
     */
    protected $Redis = null;

    /**
     * @param Client $Redis
     */
    public function __construct(Client $Redis) {
        $this->setRedis($Redis);
    }

    /**
     * @param string $email
     * @param string $name
     * @param string $password
     * @return User
     * @throws Exception
     */
    public function registerUser($email, $name, $password) {
        if ($this->getIdByName($name)) {
            throw new Exception("User with name {$name} already exists");
        }

        $User = new User([
            User::FIELD_EMAIL => $email,
            User::FIELD_NAME => $name,
            User::FIELD_PASSWORD => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $User->save();
        $this->saveNameIdIndex($name, $User->getId());

        return $User;
    }

    /**
     * @param $name
     * @param $password
     * @return User|null
     * @throws Exception
     */
    public function auth($name, $password) {
        $id = $this->getIdByName($name);
        if (!$id) {
            throw new Exception("User with name {$name} not found");
        }

        $User = Kernel::getRepository(EntityType::USER)->loadById($id);
        if (password_verify($password, $User->get(User::FIELD_PASSWORD))) {
            return $User;
        }

        return null;
    }

    /**
     * @param $name
     * @param $id
     */
    protected function saveNameIdIndex($name, $id) {
        $this->getRedis()->set('index:user:name:' . $name, $id);
    }

    /**
     * @param $name
     * @return string
     */
    protected function getIdByName($name) {
        return $this->getRedis()->get('index:user:name:' . $name);
    }

    /**
     * @return Client
     */
    protected function getRedis() {
        return $this->Redis;
    }

    /**
     * @param Client $Redis
     */
    protected function setRedis(Client $Redis) {
        $this->Redis = $Redis;
    }
}