<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\ItemMaster;

class ItemMasterController extends Controller
{
    public $categories = [
        '従量課金型科目',
        '単独課金型科目',
        '諸費用',
        '割引',
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $auths = Auth::user();
        $subject_qtys = $auths->item_masters->where('category', '1');
        $subject_singles = $auths->item_masters->where('category', '2');
        $charges = $auths->item_masters->where('category', '3');
        $discounts = $auths->item_masters->where('category', '4');

        return view('item_master.index', [
            'subject_qtys' => $subject_qtys,
            'subject_singles' => $subject_singles,
            'charges' => $charges,
            'discounts' => $discounts,
            'categories' => $this->categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item_master = new ItemMaster;
        return view('item_master.create', [
            'item_master' => $item_master,
            'categories' => $this->categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
