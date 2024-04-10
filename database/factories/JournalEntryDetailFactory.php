<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JournalEntryDetail>
 */
class JournalEntryDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'journal_entry_header_id' => $this->faker->randomNumber(5),
            'debit' => $this->faker->randomFloat(2, 1, 1000),
            'credit' => $this->faker->randomFloat(2, 1, 1000),
            'notes' => $this->faker->text,
        ];
    }
}
