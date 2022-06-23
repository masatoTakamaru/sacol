<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\ItemMaster;
use App\Http\Requests\ItemMasterRequest;

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
        $subject_qtys = $auths->item_masters->where('category', '1')->sortBy('code');
        $subject_singles = $auths->item_masters->where('category', '2')->sortBy('code');
        $charges = $auths->item_masters->where('category', '3')->sortBy('code');
        $discounts = $auths->item_masters->where('category', '4')->sortBy('code');

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
    public function store(ItemMasterRequest $request)
    {
        $auths = Auth::user();
        $auths->item_masters()->create([
            'code' => (int) $request->code,
            'category' => (int) $request->category,
            'name' => $request->name,
            'price' => (int) $request->price,
            'description' => $request->description,
        ]);

        session()->flash('flashmessage', '生徒が登録されました。');

        return redirect()->route('item_master.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auths = Auth::user();
        $item_master = $auths->item_masters()->find((int) Hashids::decode($id)[0]);
        return view('item_master.edit', [
            'item_master' => $item_master,
            'categories' => $this->categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemMasterRequest $request, $id)
    {
        $auths = Auth::user();
        $item_master = $auths->item_masters()->find($id)->update([
            'code' => (int) $request->code,
            'category' => (int) $request->category,
            'name' => $request->name,
            'price' => (int) $request->price,
            'description' => $request->description,
        ]);

        session()->flash('flashmessage', '科目の情報が更新されました。');

        return redirect()->route('item_master.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auths = Auth::user();
        $auths->item_masters()->find($id)->delete();

        session()->flash('flashmessage', '科目が削除されました。');

        return redirect()->route('item_master.index');
    }
}
