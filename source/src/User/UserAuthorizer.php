<?php
namespace User;

class UserAuthorizer {
    /**
     * @param string $email
     * @param string $login
     * @param string $passwordHash
     * @return User
     */
    public function registerUser($email, $login, $passwordHash) {
        $User = new User([
            User::FIELD_EMAIL => $email,
            User::FIELD_LOGIN => $login,
            User::FIELD_PASSWORD => $passwordHash,
        ]);

        $User->save();
        return $User;
    }

    public function auth($login, $password) {

    }
}