<?php

namespace Tests\Feature\test;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class SheetStoreTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @test
     * @group sheet
     */
    public function 新規帳票が作成できる()
    {
        $response = $this->actingAs(User::find(1))
            ->post(route('sheet.store'),[
                'year' => 2000,
                'month' => 1,
            ]);
        $response = $this
            ->assertDatabaseHas('sheets', ['month' => 5]);
    }
}
