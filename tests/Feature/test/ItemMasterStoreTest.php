<?php

namespace Tests\Feature\test;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\ItemMaster;

class ItemMasterStoreTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @test
     * @group item_master
    */
    public function 科目を登録したら一覧にリダイレクトされる()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertRedirect(route('item_master.index'));
    }

    /**
     * @test
     * @group item_master
    */
    public function 登録した科目が一覧に表示される()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data);

        $response = $this
            ->get(route('item_master.index'))
            ->assertSee($data['name']);
    }
    
    /**
     * @test
     * @group item_master
    */
    public function コードが空白は不可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['code'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertInValid(['code' => 'コードは、必ず指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function コードが数字以外は不可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['code'] = 'あいうえお';
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertInValid(['code' => 'コードには、整数を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function コードが負の数は不可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['code'] = -1;
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertInValid(['code' => 'コードには、1から、9999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function コードが0は不可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['code'] = 0;
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertInValid(['code' => 'コードには、1から、9999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function コードが10000以上は不可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['code'] = 10000;
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertInValid(['code' => 'コードには、1から、9999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function 種別が未選択は不可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['category'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertInValid(['category' => '種別は、必ず指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function 価格が空白は不可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['price'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertInValid(['price' => '価格は、必ず指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function 価格が負の数は不可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['price'] = -1;
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertInValid(['price' => '価格には、0から、999999までの数字を指定してください。']);
    }

        /**
     * @test
     * @group item_master
    */
    public function 価格が0は可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['price'] = 0;
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertValid();
    }

    /**
     * @test
     * @group item_master
    */
    public function 価格が1000000以上は不可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['price'] = 1000000;
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertInValid(['price' => '価格には、0から、999999までの数字を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function 価格が全角文字は不可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['price'] = '１０００';
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertInValid(['price' => '価格には、整数を指定してください。']);
    }

    /**
     * @test
     * @group item_master
    */
    public function 摘要が空白は可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['description'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertValid();
    }

    /**
     * @test
     * @group item_master
    */
    public function 摘要が51字以上は不可()
    {
        $data = ItemMaster::factory()->make()->toArray();
        $data['description'] = str_repeat('あ', 51);
        $response = $this->actingAs(User::find(1))
            ->post(route('item_master.store'), $data)
            ->assertInValid(['description' => '摘要は、50文字以下にしてください。']);
    }

}
