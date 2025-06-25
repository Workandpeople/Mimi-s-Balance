<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Card;
use App\Models\Category;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'filename' => 'facture_' . $this->faker->uuid() . '.pdf',
            'original_name' => $this->faker->word() . '.pdf',
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'invoice_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'merchant' => $this->faker->company(),
            'card_id' => Card::inRandomOrder()->first()->id ?? null,
            'category_id' => Category::inRandomOrder()->first()->id ?? null,
        ];
    }
}