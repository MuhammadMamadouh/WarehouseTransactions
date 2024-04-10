<?php

namespace Tests\Feature;

use App\Models\TransactionHeader;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NormalB2BTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;
    private $user;

    // public function setUp(): void
    // {
    //     parent::setUp();
    //     $this->user = User::factory()->create();
    //     $this->actingAs($this->user, 'sanctum');
    // }

    public function test_b2bnormal_so_index_with_valid_type()
    {

        // create a normal B2B sales order
        TransactionHeader::factory()
            ->count(10)
            ->hasDetails(5)
            ->hasFromWarehouse()
            ->create([
                'transaction_type' => TransactionHeader::NORMAL_B2B_SALES,
                'to_warehouse_id' => function () {
                    return \App\Models\Warehouse::factory()->create()->id;
                },
                'from_warehouse_id' => null,
            ]);

        $response = $this->get('api/transaction?type=B2B');
        $response->assertStatus(200);

        $data = $response->json('data');

        // Loop over each item and assert that transaction_type is 'Normal B2B Sales'
        foreach ($data as $index => $item) {
            $response->assertJsonPath("data.$index.transaction_type", 'Normal B2B Sales');
        }
    }

    // public function test_b2bnormal_so_index_with_invalid_type()
    // {
    //     $this->actingAs($this->user, 'sanctum');
    //     $response = $this->get('transaction?type=InvalidType');

    //     $response->assertStatus(400);
    // }
}
