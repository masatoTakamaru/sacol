<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Str;

class FamilyGroupController extends Controller
{
    public $grades = [
        '未就学','年少','年中','年長','小学１年',
        '小学２年','小学３年','小学４年','小学５年','小学６年',
        '中学１年','中学２年','中学３年','高校１年','高校２年',
        '高校３年',
    ];

    public function edit($id)
    {
        $user = Auth::user();
        $student = $user->students->find(Hashids::decode($id)[0]);
        $students = $user->students;

        return view('family_group.edit',[
            'student' => $student,
            'students' => $students,
            'grades' => $this->grades,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $student = $user->students->find(Hashids::decode($id)[0]);
        $students = $user->students;

        $family_member = $user->students->find($request->id);
        $family_member->family_group = $request->family_group;
        $family_member->save();

        return view('family_group.edit',[
            'student' => $student,
            'students' => $students,
            'grades' => $this->grades,
        ]);
    }
}
