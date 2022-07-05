<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class StudentTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */

    /** @test */
    public function 生徒が新規登録できる()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/student/create')
                    ->keys('#registered_date', '2022', '{tab}', '4', '1')
                    ->type('family_name', '田中')
                    ->type('given_name', '太郎')
                    ->type('family_name_kana', 'タナカ')
                    ->type('given_name_kana', 'タロウ')
                    ->select('gender', '女')
                    ->select('grade', '12')
                    ->type('email', 'test@gmail.com')
                    ->type('remarks', 'テストメッセージ')
                    ->press('登録する')
                    ->assertPathIs('/student')
                    ->assertSee('田中 太郎');
        });
    }

    /** @test */
    public function 生徒が編集できる()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/student')
                ->clickLink('福士 天翔')
                ->assertSee('編集');
                /*
                ->clickLink('編集')
                ->keys('#registered_date', '2021', '{tab}', '11', '12')
                ->type('family_name', '佐藤')
                ->type('given_name', '次郎')
                ->type('family_name_kana', 'サトウ')
                ->type('given_name_kana', 'ジロウ')
                ->select('gender', '男')
                ->select('grade', '14')
                ->type('email', 'test2@gmail.com')
                ->type('remarks', '変更メッセージ')
                ->press('更新する')
                ->assertPathIs('/student')
                ->assertSee('佐藤 次郎');
                */
        });
    }
}
