<?php

namespace App\Entities;

use Exception;

class AdminCredentialsEntity
{
    private string $email;
    private string $password;

    public function __construct(array $data)
    {
        if (!isset($data['email'])) {
            throw new Exception('Email is missing!');
        }
        if (!isset($data['password'])) {
            throw new Exception('Password is missing!');
        }

        $this->email = $data['email'];
        $this->password = $data['password'];
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'active' => 1,
        ];
    }
}
