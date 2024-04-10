<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // run factory of transaction header with factory of warehouse
        \App\Models\TransactionHeader::factory()
            ->count(10)
            ->hasWarehouse()
            ->create();

    }
}
