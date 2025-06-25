<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Alimentation', 'color' => '#FF6384'],
            ['name' => 'Transport', 'color' => '#36A2EB'],
            ['name' => 'Santé', 'color' => '#FFCE56'],
            ['name' => 'Loisirs', 'color' => '#4BC0C0'],
            ['name' => 'Éducation', 'color' => '#9966FF'],
            ['name' => 'TVA', 'color' => '#cccccc'],
            ['name' => 'Fournitures de bureau', 'color' => '#f9a825'],
            ['name' => 'Matériel', 'color' => '#6a1b9a'],
            ['name' => 'Services externes', 'color' => '#00897b'],
            ['name' => 'Abonnements', 'color' => '#ef6c00'],
            ['name' => 'Frais de déplacement', 'color' => '#039be5'],
            ['name' => 'Frais de péage', 'color' => '#8d6e63'],
            ['name' => 'Carburant', 'color' => '#43a047'],
            ['name' => 'Hébergement', 'color' => '#ab47bc'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate(
                ['name' => $category['name']],
                [
                    'id' => \Illuminate\Support\Str::uuid(),
                    'color' => $category['color'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}