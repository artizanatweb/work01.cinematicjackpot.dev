<?php

namespace Database\Seeders;

use App\Models\VatTax;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VatTaxSeeder extends ConsoleSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $initialVat = (int) env('INITIAL_VAT_TAX', 0);
        VatTax::firstOrCreate([
            'date' => Carbon::parse('2024-01-01 00:00:00'),
            'amount' => $initialVat,
        ]);

        $this->success("Added VAT tax record for default amount: {$initialVat}");
    }
}
