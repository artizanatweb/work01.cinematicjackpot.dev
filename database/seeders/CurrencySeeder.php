<?php

namespace Database\Seeders;

use App\Repositories\Interfaces\CurrencyRepository;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Output\ConsoleOutput;
use Exception;

class CurrencySeeder extends ConsoleSeeder
{
    public function __construct(
        private readonly CurrencyRepository $repository,
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
            $this->addRON();
            $this->success("Currency RON added to DB!");
        } catch (Exception $e) {
            $this->error("Failed to add RON currency because: {$e->getMessage()}");
        }

        try {
            $this->addEUR();
            $this->success("Currency EUR added to DB!");
        } catch (Exception $e) {
            $this->error("Failed to add EUR currency because: {$e->getMessage()}");
        }

        try {
            $this->addUSD();
            $this->success("Currency USD added to DB!");
        } catch (Exception $e) {
            $this->error("Failed to add USD currency because: {$e->getMessage()}");
        }
    }

    private function addRON(): void
    {
        $this->repository->make(
            alphabeticCode: 'ron',
            numericCode: '946',
            name: 'Leu românesc',
            symbol: 'Lei',
        );
    }

    private function addEUR()
    {
        $this->repository->make(
            alphabeticCode: 'eur',
            numericCode: '978',
            name: 'Euro',
            symbol: '€',
        );
    }

    private function addUSD()
    {
        $this->repository->make(
            alphabeticCode: 'usd',
            numericCode: '840',
            name: 'United States dollar',
            symbol: '$',
        );
    }
}
