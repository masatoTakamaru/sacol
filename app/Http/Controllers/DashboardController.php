<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Vinkla\Hashids\Facades\Hashids;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $sheets = $user->sheets;
        //帳票を年月の新しい方から順に並べかえ
        if($sheets->count()) {
            $sheets = $sheets->sort(function($first, $second) {
                if($first['year'] == $second['year']) {
                    return $first['month'] < $second['month'] ? 1 : -1;
                }
                return $first['year'] < $second['year'] ? 1 : -1;
            });
        }

        return view('dashboard', ['sheets' => $sheets]);
    }    
}
