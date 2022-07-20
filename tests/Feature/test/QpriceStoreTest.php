<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class QpriceStoreTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @test
     * @group qprice
     */
    public function 従量課金型科目の設定が更新できる()
    {
        $prices = [
            1 => 210000,
            2 => 220000,
            3 => 230000,
            4 => 240000,
            5 => 250000,
            6 => 260000,
            7 => 270000,
            8 => 280000,
            9 => 290000,
            10 => 300000,
            11 => 310000,
            12 => 320000,
        ];
        $response = $this->actingAs(User::find(1))
            ->put(route('qprice.update', ['grade' => 0]), [
                'price' => $prices,
            ]);
        $responset = $this
            ->assertDatabaseHas('qprices', [
                'grade' => 0,
                'qprice' => 1,
                'price' => 210000,
            ]);
    }
}
