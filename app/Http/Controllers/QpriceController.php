<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Qprice;
use App\Http\Requests\QpriceRequest;

class QpriceController extends Controller
{
    public $grades = [
        '未就学','年少','年中','年長','小学１年',
        '小学２年','小学３年','小学４年','小学５年','小学６年',
        '中学１年','中学２年','中学３年','高校１年','高校２年',
        '高校３年',
    ];

    public function edit($grade)
    {
        $user = Auth::user();
        //初期データがない場合新規作成
        if(!$user->qprices->count()) {
            $data = [];
            for ($g = 0; $g <= 15; $g++) {
                for ($q = 1; $q <= 12; $q++) {
                    array_push($data, [
                        'grade' => $g,
                        'qprice' => $q,
                        'price' => 0,
                    ]);
                }
            }
            $user->qprices()->createMany($data);
        }

        $qprices = $user->qprices()->where('grade', $grade)->get();

        return view('qprice.edit', [
            'qprices' => $qprices,
            'grades' => $this->grades,
            'grade' => (int) $grade,
        ]);
    }

    public function update(QpriceRequest $request, $grade)
    {
        $user = Auth::user();
        $qprices = $user->qprices->where('grade', $grade);
        foreach ($request->price as $key => $value) {
            $qp = $qprices->where('qprice', $key)->first();
            $qp->update(['price' => $value]);
        }
        session()->flash('flashmessage', '価格が更新されました。');

        return redirect()->route('qprice.edit', ['grade' => $grade]);
    }
}
