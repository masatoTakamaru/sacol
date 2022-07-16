<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Auth;
use Vinkla\Hashids\Facades\Hashids;

class SheetUpdateTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function setUp() :void
    {
        parent::setUp();

        $response = $this->actingAs(User::find(1));
        $response = $this
            ->post(route('student.store'), [
                'registered_date' => '2000-01-01',
                'family_name' => '田中',
                'given_name' => '太郎',
                'family_name_kana' => 'タナカ',
                'given_name_kana' => 'タロウ',
                'gender' => '男',
                'grade' => '0',
                'email' => '',
                'remarks' => '',
            ]);
        $user = Auth::user();
        $this->sheet = $user->sheets()->find(1);
        $this->st = $user->students()->where([
            ['family_name', '田中'],
            ['given_name', '太郎'],
        ])->first();
        //金額計算のためにダミーデータを登録する
        $response = $this
            ->post(route('item.store'), [
                'sheet_id' => $this->sheet->id,
                'student_id' => $this->st->id,
                'code' => 1,
                'category' => 2,
                'name' => 'testName',
                'price' => 0,
                'description' => '',
            ]);
        $this->expect = $user->sheets()->find(1)->sales;
    }

    /**
     * @test
     * @group sheet
     */
    public function 科目を追加すると帳票の請求額が変更される()
    {
        $response = $this
            ->post(route('item.store'), [
                'sheet_id' => $this->sheet->id,
                'student_id' => $this->st->id,
                'code' => 1,
                'category' => 2,
                'name' => 'testName',
                'price' => 1234,
                'description' => '',
            ]);
        $user = Auth::user();
        $sheet = $user->sheets()->find(1);
        $response = $this
            ->assertSame(1234, $sheet->sales);
    }

    /**
     * @test
     * @group sheet
     */
    public function 科目を複数追加すると帳票の請求額が変更される()
    {
        $response = $this
            ->post(route('item.store'), [
                'sheet_id' => $this->sheet->id,
                'student_id' => $this->st->id,
                'code' => 1,
                'category' => 2,
                'name' => 'testName',
                'price' => 1000,
                'description' => '',
            ]);
        $response = $this
            ->post(route('item.store'), [
                'sheet_id' => $this->sheet->id,
                'student_id' => $this->st->id,
                'code' => 1,
                'category' => 3,
                'name' => 'testName',
                'price' => 2000,
                'description' => '',
            ]);
        $response = $this
            ->post(route('item.store'), [
                'sheet_id' => $this->sheet->id,
                'student_id' => $this->st->id,
                'code' => 1,
                'category' => 4,
                'name' => 'testName',
                'price' => 500,
                'description' => '',
            ]);

        $user = Auth::user();
        $sheet = $user->sheets()->find(1);
        $response= $this
            ->assertSame(2500, $sheet->sales);
    }
}
