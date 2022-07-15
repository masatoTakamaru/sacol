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
        $auths = Auth::user();
        $sheet = $auths->sheets()->create([
            'year' => (int) $request->year,
            'month' => (int) $request->month,
            'enrollment' => 0,
            'sales' => 0,
        ]);

        $this->update($sheet->id);

        session()->flash('flashmessage', '帳票が作成されました。');

        return redirect()->route('dashboard');
    }

    public function update($id)
    {
        $auths = Auth::user();
        $sheet = $auths->sheets()->find($id);
        if (!$sheet) return redirect()->route('dashboard'); //例外処理
        
        $date = Carbon::createFromDate($sheet->year, $sheet->month, 1);
        $students = $auths->students()
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
        $auths = Auth::user();
        $sheet = $auths->sheets()->find($id);
        if (!$sheet) return redirect()->route('dashboard'); //例外処理

        //帳票に関連する科目も削除
        $auths->items()->where('sheet_id', $sheet->id)->delete();

        $sheet->delete();

        session()->flash('flashmessage', '帳票が削除されました。');

        return redirect()->route('dashboard');

    }
}
