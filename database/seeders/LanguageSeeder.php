<?php

namespace Database\Seeders;

use App\Repositories\Interfaces\CurrencyRepository;
use App\Repositories\Interfaces\LanguageRepository;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Output\ConsoleOutput;
use Exception;

class LanguageSeeder extends ConsoleSeeder
{
    public function __construct(
        private readonly LanguageRepository $repository,
        private readonly CurrencyRepository $currencyRepository,
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
        Model::unguard();

        try {
            $this->addRomanian();
        } catch (Exception $e) {
            $this->error("Failed to add Romanian language because: {$e->getMessage()}");
        }

        try {
            $this->addEnglish();
        } catch (Exception $e) {
            $this->error("Failed to add English language because: {$e->getMessage()}");
        }
    }

    private function addRomanian(): void
    {
        $currency = $this->currencyRepository->findByAlphaCode('ron');

        $this->repository->make(
            code: 'ro',
            name: 'Română',
            currency: $currency,
            id: 1,
        );

        $this->success("Language Romanian added to DB!");
    }

    private function addEnglish(): void
    {
        $currency = $this->currencyRepository->findByAlphaCode('eur');

        $this->repository->make(
            code: 'en',
            name: 'English',
            currency: $currency,
            id: 2,
        );

        $this->success("Language English added to DB!");
    }
}
