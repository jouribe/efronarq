<?php

namespace Database\Seeders;

use App\Models\Origin;
use Illuminate\Database\Seeder;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Origin::create([
            'name' => 'Cartel',
        ]);

        Origin::create([
            'name' => 'Urbania'
        ]);
    }
}
