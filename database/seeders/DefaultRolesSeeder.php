<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;

class DefaultRolesSeeder extends ConsoleSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->makeDefaultRoles();
    }

    private function makeDefaultRoles(): array
    {
        $owner = Role::create([ 'name' => 'owner' ]);
        $admin = Role::create([ 'name' => 'admin' ]);
        $client = Role::create([ 'name' => 'client' ]);

        return [
            $owner,
            $admin,
            $client,
        ];
    }
}
