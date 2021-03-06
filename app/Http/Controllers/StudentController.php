<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Http\Requests\StudentRequest;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        $user = Auth::user();
        $students = $user->students->where('expired_flg', false);
        return view('student.index', [
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
        $user = Auth::user();
        $user->students()->create([
            'registered_date' => $request->registered_date,
            'expired_flg' => '0',
            'expired_date' => '9999-12-31',
            'family_name' => $request->family_name,
            'given_name' => $request->given_name,
            'family_name_kana' => $request->family_name_kana,
            'given_name_kana' => $request->given_name_kana,
            'gender' => $request->gender,
            'grade' => $request->grade,
            'family_group' => Str::uuid(),
            'email' => $request->email,
            'remarks' => $request->remarks,
        ]);

        session()->flash('flashmessage', '生徒が登録されました。');

        return redirect()->route('student.index');
    }

    public function show($id)
    {
        $user = Auth::user();
        $st = $user->students()->find((int) Hashids::decode($id)[0]);
        $family_members = $user->students()
            ->where([
                ['family_group', $st->family_group],
                ['id', '<>', $st->id],
            ])
            ->get();
        return view('student.show', [
            'st' => $st,
            'grades' => $this->grades,
            'family_members' => $family_members,
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
        $user = Auth::user();
        $student = $user->students()->find((int) Hashids::decode($id)[0]);
      
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
    public function update(StudentRequest $request, $id)
    {
        $user = Auth::user();

        $user->students()->find($id)->update($request->all());

        session()->flash('flashmessage', '生徒の情報が更新されました。');

        return redirect()->route('student.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $user->students()->find($id)->delete();

        session()->flash('flashmessage', '生徒が削除されました。');

        return redirect()->route('student.index');

    }

    public function expired_index()
    {
        $user = Auth::user();
        $students = $user->students
            ->where('expired_flg', true)
            ->sortByDesc('expired_date');
        return view('student.expired_index', [
            'students' => $students,
            'grades' => $this->grades,
        ]);
    }

    public function expired_update(Request $request, $id)
    {

        if (!$request['expired_date']) {
            $validator = Validator::make($request->all(), []);
            $validator->errors()->add('expired_date', '退会日を入力してください。');
            return back()->withInput()->withErrors($validator);
        } else {
            $user = Auth::user();
            $user->students()->find($id)->update([
                'expired_flg' => true,
                'expired_date' => $request['expired_date'],
            ]);
    
            session()->flash('flashmessage', '生徒を退会者名簿に移動しました。');    
        }

        return redirect()->route('student.index');
    }

    public function unexpired_update(Request $request, $id)
    {
        $user = Auth::user();
        $user->students()->find($id)->update(['expired_flg' => false]);

        session()->flash('flashmessage', '生徒の退会を取り消しました。');

        return redirect()->route('student.index');
    }
}
