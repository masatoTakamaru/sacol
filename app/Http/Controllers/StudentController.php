<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Http\Requests\StudentRequest;

class StudentController extends Controller
{
    public $genders = ['男', '女', 'その他'];
    public $grades = [
        '未就学','年少','年中','年長','小学１年',
        '小学２年','小学３年','小学４年','小学５年','小学６年',
        '中学１年','中学２年','中学３年','高校１年','高校２年',
        '高校３年',
    ];
     
    public function index()
    {
        $auths = Auth::user();
        $st_groups = $auths->student_groups->pluck('name', 'id')->toArray();
        $students = $auths->students->where('expired_date', '=', NULL);
        return view('student.index', [
            'st_groups' => $st_groups,
            'students' => $students,
            'grades' => $this->grades,
        ]);
    }

    public function create()
    {
        $st = new Student;
        return view('student.create', [
            'st' => $st, 
            'genders' => $this->genders,
            'grades' => $this->grades,
        ]);
    }

    public function store(StudentRequest $request)
    {
        $auths = Auth::user();
        $auths->students()->create($request->all());

        return redirect()
            ->route('student.index')
            ->with('flash','生徒が登録されました。');
    }

    public function show($id)
    {
        $auths = Auth::user();
        $student = $auths->students->find($id);
        return view('student.show', [
            'st' => $student,
            'grades' => $this->grades,
        ]);
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
        $student = $auths->students->find($id);
        return view('student.edit', [
            'st' => $student,
            'genders' => $this->genders,
            'grades' => $this->grades,
        ]);
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
