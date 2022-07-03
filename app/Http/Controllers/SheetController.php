<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SheetRequest;
use Auth;

class SheetController extends Controller
{
    public function store(SheetRequest $request)
    {
        $auths = Auth::user();
        $auths->sheets()->create([
            'year' => (int) $request->year,
            'month' => (int) $request->month,
            'enrollment' => 0,
            'sales' => 0,
        ]);

        session()->flash('flashmessage', '帳簿が作成されました。');

        return redirect()->route('dashboard');
    }
}
