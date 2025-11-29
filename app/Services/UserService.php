<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepository;

class UserService
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {}

    public function deactivateAdmin2FA(): int
    {
        return $this->repository->setAdmins2FA(false);
    }
}
