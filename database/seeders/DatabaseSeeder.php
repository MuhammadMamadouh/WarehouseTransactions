<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // run factory of warehouse
        // \App\Models\Warehouse::factory()
        //     ->count(10)
        //     ->create();

        // // run factory of item
        \App\Models\Item::factory()
            ->count(10)
            ->hasWarehouses(5)
            ->create();

        // run factory of transaction header with factory of warehouse
        // \App\Models\TransactionHeader::factory()
        //     ->count(10)
        //     ->hasDetails(5)
        //     ->hasToWarehouse()
        //     ->create();

        // run factory of transaction detail with factory of item


    }
}
