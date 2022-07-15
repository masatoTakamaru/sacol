<?php

namespace Tests\Feature\test;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Arr;
use Auth;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;

class ItemStoreTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function setUp() :void
    {
        parent::setUp();
        $response = $this->actingAs(User::find(1));
        $auth = Auth::user();
        $sheet = $auth->sheets()->find(1);
        $st = $auth->students()->find(1);
        $this->item = [
            'sheet_id' => $sheet->id,
            'student_id' => $st->id,
            'code' => 1,
            'category' => 1,
            'name' => 'testName',
            'price' => 1234,
            'description' => '',
        ];
        $this->st = $st;
        $this->sheet = $sheet;
    }

    /**
     * @test
     * @group item
    */
    public function 科目を登録したら編集画面にリダイレクトされる()
    {
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertRedirect(route('item.edit', [
                'student' => Hashids::encode($this->st->id),
                'sheet' => Hashids::encode($this->sheet->id),
            ]));
        
    }

    /**
     * @test
     * @group item
    */
    public function 登録した科目が編集画面に表示される()
    {
        $this->item['description'] = 'test_data';
        $response = $this
            ->post(route('item.store'), $this->item);
        $response = $this
            ->get(route('item.edit', [
                'student' => Hashids::encode($this->st->id),
                'sheet' => Hashids::encode($this->sheet->id),
            ]))
            ->assertSee($this->item['description']);
    }
    
    /**
     * @test
     * @group item
    */
    public function コードが空白は不可()
    {
        $this->item['code'] = '';
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['code' => 'コードは、必ず指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function コードが負の数は不可()
    {
        $this->item['code'] = -1;
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['code' => 'コードには、1から、9999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function コードが0は不可()
    {
        $this->item['code'] = 0;
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['code' => 'コードには、1から、9999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function コードが10000以上は不可()
    {
        $this->item['code'] = 10000;
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['code' => 'コードには、1から、9999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function コードが全角文字は不可()
    {
        $this->item['code'] = '１００１';
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['code' => 'コードには、整数を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function コードが数字以外は不可()
    {
        $this->item['code'] = '1DDA';
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['code' => 'コードには、整数を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 種別名が未選択は不可()
    {
        $this->item['category'] = '';
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['category' => '種別は、必ず指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 価格が空白は不可()
    {
        $this->item['category'] = 2;
        $this->item['price'] = '';
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['price' => '価格は、必ず指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 価格が負の数は不可()
    {
        $this->item['category'] = 2;
        $this->item['price'] = -1;
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['price' => '価格には、0から、999999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 価格が0は可()
    {
        $this->item['category'] = 2;
        $this->item['price'] = 0;
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertValid();
    }

    /**
     * @test
     * @group item
    */
    public function 価格が1000000以上は不可()
    {
        $this->item['category'] = 2;
        $this->item['price'] = 1000000;
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['price' => '価格には、0から、999999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 価格が全角文字は不可()
    {
        $this->item['category'] = 2;
        $this->item['price'] = '１０００';
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['price' => '価格には、整数を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 摘要が空白は可()
    {
        $this->item['description'] = '';
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertValid();
    }

    /**
     * @test
     * @group item
    */
    public function 摘要が51字以上は不可()
    {
        $this->item['description'] = str_repeat('あ', 51);
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['description' => '摘要は、50文字以下にしてください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 従量課金型科目を13個以上登録は不可()
    { 
        $response = $this
            ->post(route('item.store'), $this->item)
            ->assertInValid(['description' => '摘要は、50文字以下にしてください。']);
    }


}
