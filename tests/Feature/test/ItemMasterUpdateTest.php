<?php

namespace Tests\Feature\test;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\ItemMaster;
use Auth;

class ItemMasterUpdateTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @test
     * @group item_master
    */
    public function 科目を更新したら一覧にリダイレクトされる()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['code'] = mt_rand(5000,6000);
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertRedirect(route('item_master.index'));
    }

    /**
     * @test
     * @group item_master
    */
    public function 科目を更新したら一覧に反映される()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['code'] = mt_rand(5000,6000);
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data);
        $response = $this
            ->get(route('item_master.index'))
            ->assertSee($data['code']);
    }

    /**
     * @test
     * @group item_master
    */
    public function コードが空白は不可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['code'] = '';
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertInValid(['code' => 'コードは、必ず指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function コードが数字以外は不可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['code'] = 'あいうえお';
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertInValid(['code' => 'コードには、整数を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function コードが負の数は不可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['code'] = -1;
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertInValid(['code' => 'コードには、1から、9999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function コードが0は不可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['code'] = 0;
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertInValid(['code' => 'コードには、1から、9999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function コードが10000以上は不可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['code'] = 10000;
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertInValid(['code' => 'コードには、1から、9999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function 種別が未選択は不可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['category'] = '';
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertInValid(['category' => '種別は、必ず指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function 価格が空白は不可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['category'] = 2;
        $data['price'] = '';
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertInValid(['price' => '価格は、必ず指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function 価格が負の数は不可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['category'] = 2;
        $data['price'] = -1;
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertInValid(['price' => '価格には、0から、999999までの数字を指定してください。']);
    }

        /**
     * @test
     * @group item_master
    */
    public function 価格が0は可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['category'] = 2;
        $data['price'] = 0;
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertValid();
    }

    /**
     * @test
     * @group item_master
    */
    public function 価格が1000000以上は不可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['category'] = 2;
        $data['price'] = 1000000;
        $response = $this
        ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertInValid(['price' => '価格には、0から、999999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function 価格が全角文字は不可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['category'] = 2;
        $data['price'] = '１０００';
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertInValid(['price' => '価格には、整数を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function 摘要が空白は可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['description'] = '';
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertValid();
    }

    /**
     * @test
     * @group item_master
    */
    public function 摘要が51字以上は不可()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $data['description'] = str_repeat('あ', 51);
        $response = $this
            ->put(route('item_master.update', ['item_master' => $item->id]), $data)
            ->assertInValid(['description' => '摘要は、50文字以下にしてください。']);
    }


}
