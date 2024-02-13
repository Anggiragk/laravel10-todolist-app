<?php
namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImpl implements UserService{
    private array $data = [
        "foo" => "foo"
    ];

    public function login(string $username, string $password) :bool{
        if (!isset($this->data[$username]) || !isset($this->data[$password])){
            return false;
        }

        return $this->data[$username] == $password;
    }
}
