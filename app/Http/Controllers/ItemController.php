<?php

namespace App\Http\Controllers;
use Auth;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\Item;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
    public $grades = [
        '未就学','年少','年中','年長','小学１年',
        '小学２年','小学３年','小学４年','小学５年','小学６年',
        '中学１年','中学２年','中学３年','高校１年','高校２年',
        '高校３年',
    ];

    public $categories = [
        '',
        '従量課金型科目',
        '単独課金型科目',
        '諸費用',
        '割引',
    ];

    public function index($year, $month)
    {
        $auths = Auth::user();
        $sheet = $auths->sheets()->where([
            ['year', $year],
            ['month', $month],
        ])->first();
        //帳簿が存在しない場合はダッシュボードにリダイレクト
        if (!$sheet) return redirect()->route('dashboard');
        //帳簿の年月に在籍している生徒を抽出
        $date = Carbon::createFromDate($year, $month, 1);
        $students = $auths->students()
            ->whereDate('registered_date', '<=', $date)
            ->whereDate('expired_date', '>=', $date)
            ->get();
        //家族グループidを抽出
        $group_ids = $students->pluck('family_group')->unique()->toArray();

        $family_groups = collect();
        $total = 0;

        //家族グループで生徒をまとめる
        foreach ($group_ids as $id) {
            $members = $students->where('family_group', $id);
            $collection = collect();

            foreach ($members as $st) {
                $items = $st->items->where('sheet_id', $sheet->id);
                $qprice = $items->where('category', 0)->first();
                $singles = $items->where('category', 2);
                $others = $items->where('category', 3);
                $discounts = $items->where('category', 4);
                //生徒の請求額を算出
                $qprice ? $fee = $qprice->price : $fee = 0;
                if($singles) $fee += $singles->sum('price');
                if($others) $fee += $others->sum('price');
                if($discounts) $fee -= $discounts->sum('price');
                $total += $fee;  //合計額に追加
                $collection->push([
                    'id' => $st->id,
                    'family_name' => $st->family_name,
                    'given_name' => $st->given_name,
                    'grade' => $st->grade,
                    'fee' => $fee,
                ]);
            }

            $family_groups->push($collection);
        }
        return view('item.index', [
            'year' => $year,
            'month' => $month,
            'family_groups' => $family_groups,
            'count' => $students->count(),
            'total' => $total,
            'grades' => $this->grades,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $auths = Auth::user();
        $st = $auths->students()->find($request->student_id);
        $sheet = $auths->sheets()
            ->where([
                ['year', $request->year],
                ['month', $request->month],
            ])->first();
        $st->items()->create([
            'sheet_id' => $sheet->id,
            'code' => (int) $request->code,
            'category' => (int) $request->category,
            'name' => $request->name,
            'price' => (int) $request->price,
            'description' => $request->description,
        ]);
        //従量課金型科目の設定
        if ($request->category == '1') {
            $count = $st->items()->where([
                    ['sheet_id', $sheet->id],
                    ['category', 1],
                ])->count();
            $price = $auths->qprices()->where([
                ['sheet_id', $sheet->id],
                ['grade', $st->grade],
                ['qprice', $count],
            ])->first();
            $st_qprice = $st->items()->where([
                ['sheet_id', $sheet->id],
                ['category', 0],
            ])->first();
            if($st_qprice) {
                $st_qprice->update([
                    'name' => $this->grades[$st->grade] . (string) $count . '教科',
                    'price' => (int) $price->price,
                ]);
            } else {
                $st->items()->create([
                    'code' => 0,
                    'year' => (int) $request->year,
                    'month' => (int) $request->month,
                    'category' => 0,
                    'name' => $this->grades[$st->grade] . (string) $count . '教科',
                    'price' => (int) $price->price,
                    'description' => $request->description,
                ]);
            }
        }
        
        $new_item = new Item;

        return redirect()->route('item.edit', [
            'student' => Hashids::encode($st->id),
            'year' => $request->year,
            'month' => $request->month,
            'items' => $st->items,
            'new_item' => $new_item,
            'grades' => $this->grades,
            'categories' => $this->categories,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $year, $month, $edit_id = null)
    {
        $auths = Auth::user();
        $st = $auths->students()->find((int) Hashids::decode($id)[0]);
        $sheet = $auths->sheets()
            ->where([
                ['year', $year],
                ['month', $month],
            ])->first();
        $items = $st->items
            ->where('sheet_id', $sheet->id);
        $new_item = new Item;

        //帳簿の生徒数・請求額の再計算
        $sheet_controller = app()->make('App\Http\Controllers\SheetController');
        $sheet_controller->update($sheet->id);

        return view('item.edit', [
            'st' => $st,
            'year' => $year,
            'month' => $month,
            'items' => $items,
            'new_item' => $new_item,
            'grades' => $this->grades,
            'categories' => $this->categories,
            'edit_id' => $edit_id,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, $id)
    {
        $auths = Auth::user();
        $item = $auths->items()->find($id);
        $sheet = $auths->sheets()->find($item->sheet_id);
        $item->update([
            'code' => $item->code,
            'category' => $item->category,
            'name' => $request->name,
            'price' => (int) $request->price,
            'description' => $request->description,
        ]);
        //帳簿の生徒数・請求額の再計算
        $sheet_controller = app()->make('App\Http\Controllers\SheetController');
        $sheet_controller->update($sheet->id);

        session()->flash('flashmessage', '情報が更新されました。');

        return redirect(route('item.edit', [
            'student' => Hashids::encode($item->student_id),
            'year' => $sheet->year,
            'month' => $sheet->month,
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auth = Auth::user();
        $item = $auth->items()->find($id);
        $sheet = $auth->sheets()->find($item->sheet_id);
        $st = $item->student;

        $item->delete();

        if ($item->category == '1') {
            $count = $st->items()
                ->where([
                    ['sheet_id', $sheet->id],
                    ['category', 1],
                ])->count();
            $price = Auth::user()->qprices()->where([
                ['sheet_id', $sheet->id],
                ['grade', $st->grade],
                ['qprice', $count],
            ])->first()->price;
            $st->items()
                ->where([
                    ['sheet_id', $sheet->id],
                    ['category', 0],
                ])->first()->update([
                    'name' => $this->grades[$st->grade] . (string) $count . '教科',
                    'price' => (int) $price,
                ]);
        }

        //帳簿の生徒数・請求額の再計算
        $sheet_controller = app()->make('App\Http\Controllers\SheetController');
        $sheet_controller->update($sheet->id);
        
        session()->flash('flashmessage', '科目が削除されました。');

        return redirect()->route('item.edit',[
            'student' => Hashids::encode($st->id),
            'year' => $sheet->year,
            'month' => $sheet->month,
        ]);
    }
}
