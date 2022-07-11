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

class ItemUpdateTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function setUp() :void
    {
        parent::setUp();
        $response = $this->actingAs(User::find(1));
        $auth = Auth::user();
        $sheet = $auth->sheets()->where([
            ['year', 2022],
            ['month', 4],
        ])->first();
        $date = Carbon::createFromDate($sheet->year, $sheet->month, 1);
        $students = $auth->students()
            ->whereDate('registered_date', '<=', $date)
            ->whereDate('expired_date', '>=', $date)
            ->get();
        $st_id = $students->pluck('id')->toArray();
        $st = $students->find(Arr::random($st_id));
        $item_master_id = $auth->item_masters()
            ->pluck('id')->toArray();
        $item = $auth->item_masters()
            ->find(Arr::random($item_master_id))
            ->toArray();
        $item['student_id'] = $st->id;
        $item['sheet_id'] = $sheet->id;
        $response = $this
            ->post(route('item.store'), $item);
        $item_posted = $auth->items()->where([
            ['student_id', $st->id],
            ['sheet_id', $sheet->id],
            ['code', $item['code']],
        ])->first();
        $this->st = $st;
        $this->sheet = $sheet;
        $this->item = $item_posted;
    }

    /**
     * @test
     * @group item
    */
    public function 科目を編集したら編集画面にリダイレクトされる()
    {
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => 'test科目名',
                'price' => $this->item->price,
                'description' => $this->item->description,    
            ])
            ->assertRedirect(route('item.edit', [
                'student' => Hashids::encode($this->st->id),
                'sheet' => Hashids::encode($this->sheet->id),
            ]));
    }

    /**
     * @test
     * @group item
    */
    public function 編集した科目が編集画面に表示される()
    {
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => 'test科目名',
                'price' => $this->item->price,
                'description' => $this->item->description,    
            ]);
        $response = $this
            ->get(route('item.edit', [
                'student' => Hashids::encode($this->st->id),
                'sheet' => Hashids::encode($this->sheet->id),
            ]))
            ->assertSee('test科目名');
    }

    /**
     * @test
     * @group item
    */
    public function 価格が空白は不可()
    {
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => 2,
                'name' => $this->item->name,
                'price' => '',
                'description' => $this->item->description,    
            ])
            ->assertInValid(['price' => '価格は、必ず指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 価格が負の数は不可()
    {
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => 3,
                'name' => $this->item->name,
                'price' => -1,
                'description' => $this->item->description,    
            ])
            ->assertInValid(['price' => '価格には、0から、999999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 価格が0は可()
    {
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => 4,
                'name' => $this->item->name,
                'price' => 0,
                'description' => $this->item->description,    
            ])
            ->assertValid();
    }

    /**
     * @test
     * @group item
    */
    public function 価格が1000000以上は不可()
    {
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => 2,
                'name' => $this->item->name,
                'price' => 1000000,
                'description' => $this->item->description,    
            ])
            ->assertInValid(['price' => '価格には、0から、999999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 価格が全角文字は不可()
    {
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => 3,
                'name' => $this->item->name,
                'price' => '１０００',
                'description' => $this->item->description,    
            ])
            ->assertInValid(['price' => '価格には、整数を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 摘要が空白は可()
    {
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => $this->item->name,
                'price' => $this->item->price,
                'description' => '',    
            ])
            ->assertValid();
    }

    /**
     * @test
     * @group item
    */
    public function 摘要が51字以上は不可()
    {
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => $this->item->name,
                'price' => $this->item->price,
                'description' => str_repeat('あ', 51),    
            ])
            ->assertInValid(['description' => '摘要は、50文字以下にしてください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 従量課金型科目の科目名が変更できる()
    {
        $this->item->code = 0;
        $this->item->category = 0;
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => 'テスト科目名',
                'price' => $this->item->price,
                'description' => $this->item->description,    
            ])
            ->assertValid();
    }

    /**
     * @test
     * @group item
    */
    public function 従量課金型科目の科目名が空白は不可()
    {
        $this->item->code = 0;
        $this->item->category = 0;
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => '',
                'price' => $this->item->price,
                'description' => $this->item->description,    
            ])
            ->assertInValid(['name' => '科目名は、必ず指定してください。']);
    }

        /**
     * @test
     * @group item
    */
    public function 従量課金型科目の科目名が21字以上は不可()
    {
        $this->item->code = 0;
        $this->item->category = 0;
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => str_repeat('あ', 21),
                'price' => $this->item->price,
                'description' => $this->item->description,    
            ])
            ->assertInValid(['name' => '科目名は、20文字以下にしてください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 従量課金型科目の金額が変更できる()
    {
        $this->item->code = 0;
        $this->item->category = 0;
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => 'テスト科目名',
                'price' => $this->item->price,
                'description' => $this->item->description,    
            ])
            ->assertValid();
    }

    /**
     * @test
     * @group item
    */
    public function 従量課金型科目の金額が0は可()
    {
        $this->item->code = 0;
        $this->item->category = 0;
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => $this->item->name,
                'price' => 0,
                'description' => $this->item->description,    
            ])
            ->assertValid();
    }

    /**
     * @test
     * @group item
    */
    public function 従量課金型科目の金額が負の数は不可()
    {
        $this->item->code = 0;
        $this->item->category = 0;
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => $this->item->name,
                'price' => -1,
                'description' => $this->item->description,    
            ])
            ->assertInValid(['price' => '価格には、0から、999999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 従量課金型科目の金額が1000000以上は不可()
    {
        $this->item->code = 0;
        $this->item->category = 0;
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => $this->item->name,
                'price' => 1000000,
                'description' => $this->item->description,    
            ])
            ->assertInValid(['price' => '価格には、0から、999999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 従量課金型科目の金額が全角文字は不可()
    {
        $this->item->code = 0;
        $this->item->category = 0;
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => $this->item->name,
                'price' => '１０００',
                'description' => $this->item->description,    
            ])
            ->assertInValid(['price' => '価格には、整数を指定してください。']);
    }

    /**
     * @test
     * @group item
    */
    public function 従量課金型科目の摘要が空白は可()
    {
        $this->item->code = 0;
        $this->item->category = 0;
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => $this->item->name,
                'price' => $this->item->price,
                'description' => '',    
            ])
            ->assertValid();
    }

    /**
     * @test
     * @group item
    */
    public function 従量課金型科目の摘要が51字以上は可()
    {
        $this->item->code = 0;
        $this->item->category = 0;
        $response = $this
            ->put(route('item.update', ['item'=>$this->item->id]), [
                'code' => $this->item->code,
                'category' => $this->item->category,
                'name' => $this->item->name,
                'price' => $this->item->price,
                'description' => str_repeat('あ', 51),    
            ])
            ->assertInValid(['description' => '摘要は、50文字以下にしてください。']);
    }

}