<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Auth;
use App\Models\User;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function LPが正しく表示される()
    {
        $response = $this->get('/');
        $response
            ->assertStatus(200)
            ->assertSee('Sacol')
            ->assertSee('ログイン')
            ->assertSee('小規模学習塾・習い事教室向け月謝管理アプリ')
            ->assertSee('新規登録はこちらから');
    }

    /** @test */
    public function ログインページが正しく表示される()
    {
        $response = $this->get('/login');
        $response
            ->assertStatus(200)
            ->assertSee('メールアドレス')
            ->assertSee('パスワード')
            ->assertSee('ログイン状態を保持する')
            ->assertSee('パスワードを忘れた方はこちら')
            ->assertSee('ログイン');
    }

    /** @test */
    public function 生徒の一覧が正しく表示される()
    {
        $this->seed();
       
        $response = $this->actingAs(User::find(1))
            ->withSession(['banned' => false])
            ->get('/student')
            ->assertStatus(200)
            ->assertSee('生徒の一覧')
            ->assertSee('中條');
    }

    /** @test */
    public function 生徒の新規登録が正しく表示される()
    {      
        $response = $this->actingAs(User::find(1))
            ->withSession(['banned' => false])
            ->get('/student/create')
            ->assertStatus(200)
            ->assertSee('生徒の一覧')
            ->assertSee('中條');
    }    
}
