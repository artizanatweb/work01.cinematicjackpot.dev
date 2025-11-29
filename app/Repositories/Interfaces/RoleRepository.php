<?php

namespace App\Repositories\Interfaces;

use App\Models\Role;

interface RoleRepository
{
    public function findBySlug(string $slug): ?Role;
}