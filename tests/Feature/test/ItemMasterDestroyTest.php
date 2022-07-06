<?php

namespace Tests\Feature\test;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\ItemMaster;
use Auth;

class ItemMasterDestroyTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @test
     * @group item_master
    */
    public function 科目を削除したら一覧にリダイレクトされる()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $response = $this
            ->delete(route('item_master.update', ['item_master' => $item->id]))
            ->assertRedirect(route('item_master.index'));
    }

        /**
     * @test
     * @group item_master
    */
    public function 科目を削除したら一覧に表示されない()
    {
        $response = $this->actingAs(User::find(1));
        $data = ItemMaster::factory()->make()->toArray();
        $item = Auth::user()->item_masters()->create($data);
        $response = $this
            ->delete(route('item_master.update', ['item_master' => $item->id]));

        $response = $this
            ->get(route('item_master.index'))
            ->assertDontSee($item['name']);
    }

}
