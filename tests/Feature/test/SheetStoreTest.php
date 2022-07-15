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
    public function 帳簿が存在しない場合新規作成のメッセージが表示される()
    {
        $response = $this->actingAs(User::find(1))
            ->get(route('dashboard'))
            ->assertSee('帳簿がありません。最初の帳簿を作成してください。');
    }

    /**
     * @test
     * @group sheet
     */
    public function 帳簿を作成したらダッシュボードに表示される()
    {
        $response = $this->actingAs(User::find(1))
            ->post(route('sheet.store'),[
                'year' => 2022,
                'month' => 3,
            ]);
        $response = $this
            ->get('dashboard')
            ->assertSee('2022 年 3 月');
    }
}
