<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SheetRequest;
use Auth;
use Carbon\Carbon;

class SheetController extends Controller
{
    public function store(SheetRequest $request)
    {
        $user = Auth::user();
        $sheets = $user->sheets;

        //前月の帳票が存在する場合，前月の帳票を引き継ぎ
        if($sheets->count()) {
            //帳票を年月の新しい方から順に並べかえ
            $sheets = $sheets->sort(function($first, $second) {
                if($first['year'] == $second['year']) {
                    return $first['month'] < $second['month'] ? 1 : -1;
                }
                return $first['year'] < $second['year'] ? 1 : -1;
            });
            //翌月の帳票の年月を取得
            $date = Carbon::create($sheets->first()->year, $sheets->first()->month, 1)
                ->addMonthNoOverflow();
            $year = $date->year;
            $month = $date->month;
            //科目の引き継ぎ
            $students = $user->students()
                ->whereDate('registered_date', '<=', $date)
                ->whereDate('expired_date', '>=', $date)
                ->get();
            foreach ($students as $st) {
                $items = $st->items->where([
                    ['sheet_id', ]
                ]);
            }
        } else {
            $year = null;
            $month = null;
        }


            

    
        $sheet = $user->sheets()->create([
            'year' => (int) $date->year,
            'month' => (int) $date->month,
            'enrollment' => 0,
            'sales' => 0,
        ]);

        $this->update($sheet->id);

        session()->flash('flashmessage', '帳票が作成されました。');

        return redirect()->route('dashboard');
    }

    public function update($id)
    {
        $user = Auth::user();
        $sheet = $user->sheets()->find($id);
        if (!$sheet) return redirect()->route('dashboard'); //例外処理
        
        $date = Carbon::createFromDate($sheet->year, $sheet->month, 1);
        $students = $user->students()
            ->whereDate('registered_date', '<=', $date)
            ->whereDate('expired_date', '>=', $date)
            ->get();

        $sales = 0;

        foreach ($students as $st) {
            $items = $st->items
                ->where('sheet_id', $id);
            $qprice = $items->where('category', 0)->first();
            $singles = $items->where('category', 2);
            $others = $items->where('category', 3);
            $discounts = $items->where('category', 4);
            //生徒の請求額を算出
            $qprice ? $fee = $qprice->price : $fee = 0;
            if($singles) $fee += $singles->sum('price');
            if($others) $fee += $others->sum('price');
            if($discounts) $fee -= $discounts->sum('price');
            $sales += $fee;  //合計額に追加
        }

        $sheet->update([
            'enrollment' =>  $students->count(),
            'sales' => $sales,
        ]);

        return $sales;
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $sheet = $user->sheets()->find($id);
        if (!$sheet) return redirect()->route('dashboard'); //例外処理

        //帳票に関連する科目も削除
        $user->items()->where('sheet_id', $sheet->id)->delete();

        $sheet->delete();

        session()->flash('flashmessage', '帳票が削除されました。');

        return redirect()->route('dashboard');

    }
}
