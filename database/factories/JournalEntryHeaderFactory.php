<?php

namespace Database\Factories;

use App\Models\JournalEntryHeader;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class JournalEntryHeaderFactory extends Factory
{


    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JournalEntryHeader::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'journal_entry_no' => $this->faker->unique()->randomNumber(5),
            'notes' => $this->faker->text,
            'debit' => $this->faker->randomFloat(2, 1, 1000),
            'credit' => $this->faker->randomFloat(2, 1, 1000),
            'date' => $this->faker->date,
        ];
    }
}
