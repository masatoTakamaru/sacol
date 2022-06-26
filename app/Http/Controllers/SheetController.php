<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Vinkla\Hashids\Facades\Hashids;
use Carbon\Carbon;

class SheetController extends Controller
{
    public $grades = [
        '未就学','年少','年中','年長','小学１年',
        '小学２年','小学３年','小学４年','小学５年','小学６年',
        '中学１年','中学２年','中学３年','高校１年','高校２年',
        '高校３年',
    ];

    public function index($year, $month)
    {
        $auths = Auth::user();
        $students = $auths->students()
            //帳簿の年月に在籍している生徒を抽出
            ->whereYear('registered_date', '<=', $year)
            ->whereMonth('registered_date', '<=', $month)
            ->whereYear('expired_date', '>=', $year)
            ->whereMonth('expired_date', '>=', $month)
            ->get();

        //家族グループidを抽出
        $group_ids = $students->pluck('family_group')->unique()->toArray();

        $family_groups = collect();

        foreach ($group_ids as $id) {
            $members = $students->where('family_group', $id);
            $collection = collect();

            foreach ($members as $st) {
                $qty = $st->items()
                    ->where([
                        ['year', $year],
                        ['month', $month],
                        ['category', 0],
                    ])->first();
                $singles = $st->items()
                    ->where([
                        ['year', $year],
                        ['month', $month],
                        ['category', 2],
                    ])->get();
                $others = $st->items()
                    ->where([
                        ['year', $year],
                        ['month', $month],
                        ['category', 3],
                    ])->get();
                $discounts = $st->items()
                    ->where([
                        ['year', $year],
                        ['month', $month],
                        ['category', 4],
                    ])->get();

                //生徒の請求額を算出
                $qty ? $fee = $qty->price : $fee = 0;
                if($qty) $name = $qty->name;
                if($singles) $fee += $singles->sum('price');
                if($others) $fee += $others->sum('price');
                if($discounts) $fee -= $discounts->sum('price');

                $collection->push([
                    'family_name' => $st->family_name,
                    'given_name' => $st->given_name,
                    'grade' => $st->grade,
                    'name' => $name,
                    'fee' => $fee,
                ]);
            }

            $family_groups->push($collection);
        }
        return view('sheet.index', [
            'year' => $year,
            'month' => $month,
            'family_groups' => $family_groups,
            'count' => $students->count(),
            'grades' => $this->grades,
        ]);
    }
}
