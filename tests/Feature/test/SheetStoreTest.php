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
    public function 帳票を作成したらダッシュボードに表示される()
    {
        $response = $this->actingAs(User::find(1))
            ->post(route('sheet.store'),[
                'year' => 2000,
                'month' => 3,
            ]);
        $response = $this
            ->get('dashboard')
            ->assertSee('2000 年 3 月');
    }
}
