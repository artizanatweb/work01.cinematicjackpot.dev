<?php

namespace App\Repositories;

use App\Entities\AdminUserEntity;
use App\Models\Role;
use App\Models\User;
use App\Models\Profile;

class UserRepository implements Interfaces\UserRepository
{

    public function findByEmail(string $email): ?User
    {
        return User::whereEmail($email)->first();
    }

    public function createAdmin(AdminUserEntity $entity): User
    {
        $user = new User();
        $user->name = $entity->name;
        $user->email = $entity->email;
        $user->password = bcrypt($entity->password);
        $user->active = $entity->active;
        $user->has_email_authentication = $entity->emailAuthentication;
        $user->saveOrFail();

        $profile = new Profile();
        if ($entity?->phone) {
            $profile->phone = $entity->phone;
        }
        if ($entity?->language) {
            $profile->language_id = $entity->language?->id;
        }
        $user->profile()->save($profile);

        return $user;
    }

    public function updateAdmin(User $user, AdminUserEntity $entity): void
    {
        $user->name = $entity->name;
        $user->email = $entity->email;
        $user->password = bcrypt($entity->password);
        $user->active = $entity->active;
        $user->has_email_authentication = $entity->emailAuthentication;
        $user->saveOrFail();

        $profile = $user->profile;
        $profile->phone = $entity->phone;
        if ($entity?->language) {
            $profile->language_id = $entity->language?->id;
        }
        $user->profile()->save($profile);
    }

    public function setAdmins2FA(bool $active = true): int
    {
        // get admin role
        $role = Role::with(['users'])->where('slug','=','admin')->first();
        // update role users column has_email_authentication with received active value
        return $role->users()->update(['has_email_authentication' => $active]);
    }
}
