<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Bank::create([
            'name' => 'BCP',
            'description' => 'Banco de Crédito del Perú',
            'currency' => 'USD',
            'contact_name' => 'Laura Landauro León',
            'contact_email' => 'llandauro@bcp.com.pe',
            'contact_phone' => '945687987'
        ]);
    }
}
