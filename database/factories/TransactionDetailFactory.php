<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'transaction_header_id' => $this->faker->randomNumber(5),
            'item_id' => function () {
                return \App\Models\Item::factory()->hasWarehouses(1, ['stock' => 100])->create()->id;
            },
            'quantity' => $this->faker->randomNumber(2),
            'cost' => $this->faker->randomDigitNotZero(),
            'price' => $this->faker->randomDigitNotZero(),
        ];
    }
}
