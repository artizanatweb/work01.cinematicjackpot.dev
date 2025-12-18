<?php

namespace App\Repositories\Interfaces;

use App\Entities\AdminUserEntity;
use App\Models\User;

interface UserRepository
{
    public function findByEmail(string $email): ?User;

    public function createAdmin(AdminUserEntity $entity): User;

    public function updateAdmin(User $user, AdminUserEntity $entity): void;

    public function setAdmins2FA(bool $active = true): int;

    public function generateOtp(User $user): void;
}
