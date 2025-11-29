<?php

namespace Database\Seeders;

use App\Enums\ProductSignageType;
use App\Models\Language;
use App\Models\ProductSignage;
use App\Repositories\Interfaces\ProductSignageRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Exception;
use Symfony\Component\Console\Output\ConsoleOutput;


class ProductSignageSeeder extends ConsoleSeeder
{
    public function __construct(
        private readonly ProductSignageRepository $repository,
        ConsoleOutput $output
    )
    {
        parent::__construct($output);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ProductSignage::count('id') > 0) {
            $this->success("Signage rows found in database", false);
            $this->info("skipping product signage step");

            return;
        }

        $languages = Language::all();

        DB::beginTransaction();
        try {
            $this->addNew($languages);
            $this->success("[signage] NEW added");
        } catch (Exception $e) {
            DB::rollBack();
            $this->error("[signage] NEW failed: " . $e->getMessage());
        }
        DB::commit();

        DB::beginTransaction();
        try {
            $this->addDiscount();
            $this->success("[signage] DISCOUNT added");
        } catch (Exception $e) {
            DB::rollBack();
            $this->error("[signage] DISCOUNT failed: " . $e->getMessage());
        }
        DB::commit();

        DB::beginTransaction();
        try {
            $this->addPromo($languages);
            $this->success("[signage] PROMO added");
        } catch (Exception $e) {
            DB::rollBack();
            $this->error("[signage] PROMO failed: " . $e->getMessage());
        }
        DB::commit();
    }

    private function addNew(Collection $languages): void
    {
        $signage = $this->repository->add(
            name: "now",
            color: "#cc0000",
            type: ProductSignageType::String,
        );

        foreach ($languages as $language) {
            $value = "NEW";
            if ('ro' === $language->code) {
                $value = "NOU";
            }
            $this->repository->addValue($signage, $language, $value);
        }
    }

    private function addDiscount(): void
    {
        $this->repository->add(
            name: "discount",
            color: "#007BFF",
            type: ProductSignageType::Discount,
        );
    }

    private function addPromo(Collection $languages): void
    {
        $signage = $this->repository->add(
            name: "oferta",
            color: "#FFA500",
            type: ProductSignageType::String,
        );

        foreach ($languages as $language) {
            $value = "PROMO";
            if ('ro' === $language->code) {
                $value = "OFERTA";
            }
            $this->repository->addValue($signage, $language, $value);
        }
    }
}
