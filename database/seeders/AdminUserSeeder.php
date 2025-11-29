<?php

namespace Database\Seeders;

use App\Entities\AdminUserEntity;
use App\Models\User;
use App\Repositories\Interfaces\LanguageRepository;
use App\Repositories\Interfaces\RoleRepository;
use App\Repositories\Interfaces\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;

class AdminUserSeeder extends ConsoleSeeder
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly RoleRepository $roleRepository,
        private readonly LanguageRepository $languageRepository,
        ConsoleOutput $output,
    )
    {
        parent::__construct($output);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $romanian = $this->languageRepository->findByCode('ro');
        $english = $this->languageRepository->findByCode('en');

        $adminEntities = get_env_admins();
        if (!(count($adminEntities) > 0)) {
            $this->error("No admin user found in .env file!");

            return;
        }

        $this->newLine();
        foreach ($adminEntities as $entity) {
            if ("Daniel" === $entity->name) {
                $entity->setLanguage($english);
            } else {
                $entity->setLanguage($romanian);
            }

            DB::beginTransaction();
            try {
                $this->addAdmin($entity);
                $this->newLine();
            } catch (Exception $e) {
                DB::rollBack();
                $this->error("Failed to create database user for {$entity->name} because of: {$e->getMessage()}");
            }
            DB::commit();
        }
        $this->newLine();
    }

    private function addAdmin(AdminUserEntity $entity): void
    {
        $user = $this->repository->findByEmail($entity->email);
        if ($user) {
            $this->repository->updateAdmin(
                user: $user,
                entity: $entity
            );

            $this->info("Admin user {$entity->name} updated!", false);
            return;
        }

        $user = $this->repository->createAdmin($entity);

        $this->success("Admin user {$entity->name} created!", false);

        $adminRole = $this->roleRepository->findBySlug('admin');
        if (!$adminRole) {
            throw new Exception("Can't find admin role! User {$entity->name} will not be added to database.");
        }
        $user->roles()->attach($adminRole);
        $this->success("Admin role assigned to user {$entity->name}.", false);

        if (!("Silviu" === $user->name)) {
            return;
        }

        $ownerRole = $this->roleRepository->findBySlug('owner');
        if (!$ownerRole) {
            return;
        }
        $user->roles()->attach($ownerRole);
        $this->success("Owner role assigned to user {$entity->name}.", false);
    }
}
