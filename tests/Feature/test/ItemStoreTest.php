<?php

namespace Tests\Feature\test;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\ItemMaster;
use App\Models\Student;
use Illuminate\Support\Arr;
use Auth;

class ItemStoreTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @test
     * @group item
    */
    public function 科目を登録したら一覧にリダイレクトされる()
    {
        $response = $this->actingAs(User::find(1));
        $st_id = Auth::user()->students()
            ->where('expired_flg', false)
            ->pluck('id')->toArray();
        $st = Auth::user()->students()
            ->find(Arr::random($st_id));
        $item_master_id = Auth::user()->item_masters()
            ->pluck('id')->toArray();
        $item = Auth::user()->item_masters()
            ->find(Arr::random($item_master_id))
            ->toArray();
        $item['student_id'] = $st->id;
        $item['year'] = 2022;
        $item['month'] = 4;

        $responset = $this
            ->post(route('item.store'), $item)
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
}
