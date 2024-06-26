<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionHeader>
 */
class TransactionHeaderFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\TransactionHeader::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $transaction_types = \App\Models\TransactionType::all()->pluck('id')->toArray();
        return [

            'code'              => 'TRX-' . $this->faker->unique()->randomNumber(5), // 'TRX-12345
            'transaction_date'  => $this->faker->date,
            'document_no'       => $this->faker->unique()->randomNumber(5),
            'from_warehouse_id' => function () {
                return \App\Models\Warehouse::factory()->create()->id;
            },
            'to_warehouse_id'   => function () {
                return \App\Models\Warehouse::factory()->create()->id;
            },
            'journal_entry_id'  => function () {
                return \App\Models\JournalEntryHeader::factory()->create()->id;
            },
            'total_price'       => $this->faker->randomFloat(2, 1, 1000),
            'total_discount'    => $this->faker->randomFloat(2, 1, 1000),
            'note'              => $this->faker->text,
            'transaction_type_id' => $this->faker->randomElement($transaction_types),

        ];
    }
}
