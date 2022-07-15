<?php

namespace Tests\Feature\test;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class SheetDestroyTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @test
     * @group sheet
     */
    public function 帳票を削除したらダッシュボードに表示されない()
    {
        $response = $this->actingAs(User::find(1))
            ->delete(route('sheet.destroy', ['sheet' => 2]));
        $response = $this
            ->get(route('dashboard'))
            ->assertDontSee('2022 年 3 月');
    }

    /**
     * @test
     * @group sheet
     */
    public function 帳票をすべて削除したら新規作成のメッセージが表示される()
    {
        for ($i = 1; $i <= 3; $i++) {
            $response = $this->actingAs(User::find(1))
            ->delete(route('sheet.destroy', ['sheet' => $i]));
        }
        $response = $this->actingAs(User::find(1))
            ->get(route('dashboard'))
            ->assertSee('帳票がありません。最初の帳票を作成してください。');
    }
}
