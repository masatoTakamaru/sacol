<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Qprice;

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
        $qprices = $user->qprices->where('grade', $grade);
        return view('qprice.edit', [
            'qprices' => $qprices,
            'grades' => $this->grades,
            'grade' => (int) $grade,
        ]);
    }

    public function update(Request $request, $grade)
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
