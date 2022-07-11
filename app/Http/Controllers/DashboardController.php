<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Vinkla\Hashids\Facades\Hashids;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $auths = Auth::user();
        $sheets = $auths->sheets;

        return view('dashboard', [
            'sheets' => $sheets,
        ]);
    }    
}
