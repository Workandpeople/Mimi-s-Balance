<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cards')->insert([
            [
                'id' => 'd6c7d764-cff0-4a9d-9eb9-d28b09cf2a1d',
                'name' => 'Visa Pro',
                'last_digits' => '1234',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'e2a55d58-317f-4e04-8f9c-7290df0451be',
                'name' => 'Perso N26',
                'last_digits' => '5678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'fa21b62f-babc-4f63-bd53-5d55ec65aa87',
                'name' => 'Boursorama',
                'last_digits' => '9012',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}