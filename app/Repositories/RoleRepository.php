<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository implements Interfaces\RoleRepository
{

    public function findBySlug(string $slug): ?Role
    {
        return Role::where('slug', $slug)->first();
    }
}