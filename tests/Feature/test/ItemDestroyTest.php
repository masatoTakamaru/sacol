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

class ItemDestroyTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function setUp() :void
    {
        parent::setUp();
        $response = $this->actingAs(User::find(1));
        $user = Auth::user();
        $sheet = $user->sheets()->where([
            ['year', 2022],
            ['month', 4],
        ])->first();
        $date = Carbon::createFromDate($sheet->year, $sheet->month, 1);
        $students = $user->students()
            ->whereDate('registered_date', '<=', $date)
            ->whereDate('expired_date', '>=', $date)
            ->get();
        $st_id = $students->pluck('id')->toArray();
        $st = $students->find(Arr::random($st_id));
        $item_master_id = $user->item_masters()
            ->pluck('id')->toArray();
        $item = $user->item_masters()
            ->find(Arr::random($item_master_id))
            ->toArray();
        $item['student_id'] = $st->id;
        $item['sheet_id'] = $sheet->id;
        $response = $this
            ->post(route('item.store'), $item);
        $item_posted = $user->items()->where([
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
    public function 科目を削除したら編集画面にリダイレクトされる()
    {
        $response = $this
            ->delete(route('item.destroy', ['item'=>$this->item->id]))
            ->assertRedirect(route('item.edit', [
                'student' => Hashids::encode($this->st->id),
                'sheet' => Hashids::encode($this->sheet->id),
            ]));
    }

    /**
     * @test
     * @group item
    */
    public function 科目を削除したら編集画面に科目が表示されない()
    {
        $response = $this
            ->delete(route('item.destroy', ['item'=>$this->item->id]));
        $response = $this
            ->get(route('item.edit', [
                'student' => Hashids::encode($this->st->id),
                'sheet' => Hashids::encode($this->sheet->id),
            ]))
            ->assertDontSee($this->item->name);
    }

}
