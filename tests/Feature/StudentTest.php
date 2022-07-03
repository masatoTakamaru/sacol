<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Vinkla\Hashids\Facades\Hashids;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public $grades = [
        '未就学','年少','年中','年長','小学１年',
        '小学２年','小学３年','小学４年','小学５年','小学６年',
        '中学１年','中学２年','中学３年','高校１年','高校２年',
        '高校３年',
    ];

    /** @test */
    public function 生徒の一覧が正しく表示されるユーザー1()
    {
        $count = User::find(1)->students->where('expired_flg', false)->count();
        $st = User::find(1)->students->where('expired_flg', false)->first();
        $response = $this->actingAs(User::find(1))
            ->get('/student')
            ->assertStatus(200)
            ->assertSee('生徒の一覧')
            ->assertSee('生徒数：' . $count . '人')
            ->assertSee('生徒の新規登録')
            ->assertSee('退会者の一覧')
            ->assertSee('学年')
            ->assertSee('名前')
            ->assertSee('フリガナ')
            ->assertSee('性別')
            ->assertSee($this->grades[$st->grade])
            ->assertSee($st->family_name)
            ->assertSee($st->given_name)
            ->assertSee($st->family_name_kana)
            ->assertSee($st->given_name_kana)
            ->assertSee($st->gender)
    }

    /** @test */
    public function 生徒の一覧が正しく表示されるユーザー2()
    {      
        $count = User::find(2)->students->where('expired_flg', false)->count();
        $st = User::find(2)->students->where('expired_flg', false)->first();
        $response = $this->actingAs(User::find(2))
            ->get('/student')
            ->assertStatus(200)
            ->assertSee('生徒の一覧')
            ->assertSee('生徒数：' . $count . '人')
            ->assertSee('生徒の新規登録')
            ->assertSee('退会者の一覧')
            ->assertSee('学年')
            ->assertSee('名前')
            ->assertSee('フリガナ')
            ->assertSee('性別')
            ->assertSee($this->grades[$st->grade])
            ->assertSee($st->family_name)
            ->assertSee($st->given_name)
            ->assertSee($st->family_name_kana)
            ->assertSee($st->given_name_kana)
            ->assertSee($st->gender)
    }
    
    /** @test */
    public function 生徒の新規登録が正しく表示される()
    {      
        $response = $this->actingAs(User::find(1))
            ->get('/student/create')
            ->assertStatus(200)
            ->assertSee('生徒の新規登録')
            ->assertSee('入会日')
            ->assertSee('生徒フリガナ')
            ->assertSee('性別')
            ->assertSee('学年')
            ->assertSee('生年月日')
            ->assertSee('学校名')
            ->assertSee('保護者姓・名')
            ->assertSee('保護者フリガナ')
            ->assertSee('電話番号１')
            ->assertSee('続柄')
            ->assertSee('電話番号２')
            ->assertSee('続柄')
            ->assertSee('メールアドレス')
            ->assertSee('備考')
            ->assertSee('*は入力必須')
            ->assertSee('登録する')
            ->assertSee('キャンセル');
    }

    /** @test */
    public function 生徒の情報が正しく表示される()
    {
        $st = User::find(1)->students()->first();

        $response = $this->actingAs(User::find(1))
            ->get('/student/' . Hashids::encode($st->id))
            ->assertStatus(200)
            ->assertSee('生徒の詳細')
            ->assertSee('学年')
            ->assertSee('名前')
            ->assertSee('フリガナ')
            ->assertSee('性別')
            ->assertSee('生年月日')
            ->assertSee('学校名')
            ->assertSee('保護者名')
            ->assertSee('フリガナ')
            ->assertSee('電話番号１')
            ->assertSee('続柄')
            ->assertSee('電話番号２')
            ->assertSee('メールアドレス')
            ->assertSee('備考')
            ->assertSee('生徒の退会')
            ->assertSee('退会日')
            ->assertSee('生徒の削除')
            ->assertSee('完全に削除する')
            ->assertSee($this->grades[$st->grade])
            ->assertSee($st->family_name)
            ->assertSee($st->given_name)
            ->assertSee($st->family_name_kana)
            ->assertSee($st->given_name_kana)
            ->assertSee($st->gender)
            ->assertSee($st->birth_date)
            ->assertSee($st->school_attended)
            ->assertSee($st->guardian_family_name)
            ->assertSee($st->guardian_given_name)
            ->assertSee($st->guardian_family_name_kana)
            ->assertSee($st->guardian_given_name_kana)
            ->assertSee($st->phone1)
            ->assertSee($st->phone1_relationship)
            ->assertSee($st->phone2)
            ->assertSee($st->phone2_relationship)
            ->assertSee($st->email)
            ->assertSee($st->remarks);
    }

    /** @test */
    public function 生徒の編集画面が正しく表示される()
    {      
        $st = User::find(1)->students()->first();

        $response = $this->actingAs(User::find(1))
            ->get('/student/' . Hashids::encode($st->id) . '/edit')
            ->assertStatus(200)
            ->assertSee('入会日')
            ->assertSee('生徒フリガナ')
            ->assertSee('性別')
            ->assertSee('学年')
            ->assertSee('メールアドレス')
            ->assertSee('備考')
            ->assertSee('*は入力必須')
            ->assertSee('更新する')
            ->assertSee('キャンセル')
            ->assertSee($this->grades[$st->grade])
            ->assertSee($st->family_name)
            ->assertSee($st->given_name)
            ->assertSee($st->family_name_kana)
            ->assertSee($st->given_name_kana)
            ->assertSee($st->gender)
            ->assertSee($st->email)
            ->assertSee($st->remarks);
    }

    /** @test */
    public function 退会者の一覧が正しく表示される()
    {      
        $count = User::find(1)->students()->where('expired_flg', true)->count();
        $st = User::find(1)->students()->where('expired_flg', true)->first();

        $response = $this->actingAs(User::find(1))
            ->get('/student/expired')
            ->assertStatus(200)
            ->assertSee('退会者の一覧')
            ->assertSee('退会者数：' . $count . '人')
            ->assertSee('学年')
            ->assertSee('名前')
            ->assertSee('フリガナ')
            ->assertSee('性別')
            ->assertSee('退会日')
            ->assertSee($this->grades[$st->grade])
            ->assertSee($st->family_name)
            ->assertSee($st->given_name)
            ->assertSee($st->family_name_kana)
            ->assertSee($st->given_name_kana)
            ->assertSee($st->gender)
            ->assertSee($st->expired_date);
    }
    
}
