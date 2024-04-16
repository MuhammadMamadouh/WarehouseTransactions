<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ItemFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Item::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'code' => $this->faker->unique()->randomNumber(5),
            'price' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }

    public function hasWarehouses($count = 1, $attributes = [])
    {
        return $this->has(
            \App\Models\Warehouse::factory()->count($count),
            'warehouses',
            function ($item, $warehouse) use ($attributes) {
                return $attributes;
            }
        );
    }

}
