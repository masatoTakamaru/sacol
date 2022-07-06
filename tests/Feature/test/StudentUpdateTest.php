<?php

namespace Tests\Feature\test;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Auth;


class StudentUpdateTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @test
     * @group student
    */
    public function 生徒を編集したら一覧にリダイレクトされる()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['given_name'] = '次郎';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertRedirect(route('student.index'));
    }

    /**
     * @test
     * @group student
    */
    public function 編集した生徒が一覧に表示される()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['given_name'] = '次郎';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data);
        $response = $this
            ->get(route('student.index'))
            ->assertSee($data['given_name']);
    }
    
    /**
     * @test
     * @group student
    */
    public function 生徒姓が空白は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['family_name'] = '';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['family_name' => '生徒姓は、必ず指定してください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 生徒姓が21字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['family_name'] = str_repeat('a', 21);
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['family_name' => '生徒姓は、20文字以下にしてください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 生徒名が空白は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['given_name'] = '';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['given_name' => '生徒名は、必ず指定してください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 生徒名が21字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['given_name'] = str_repeat('a', 21);
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['given_name' => '生徒名は、20文字以下にしてください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 生徒姓フリガナが空白は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['family_name_kana'] = '';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['family_name_kana' => '生徒姓フリガナは、必ず指定してください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 生徒姓フリガナが21字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['family_name_kana'] = str_repeat('a', 21);
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['family_name_kana' => '生徒姓フリガナは、20文字以下にしてください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 生徒姓フリガナが全角カタカナ以外は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['family_name_kana'] = 'ｱｲｳｴｵ';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['family_name_kana' => '全角カタカナで入力してください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 生徒名フリガナが空白は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['given_name_kana'] = '';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['given_name_kana' => '生徒名フリガナは、必ず指定してください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 生徒名フリガナが21字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['given_name_kana'] = str_repeat('ア', 21);
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['given_name_kana' => '生徒名フリガナは、20文字以下にしてください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 生徒名フリガナが全角カタカナ以外は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['given_name_kana'] = 'ｱｲｳｴｵ';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['given_name_kana' => '全角カタカナで入力してください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 性別未選択は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['gender'] = '';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['gender' => '性別は、必ず指定してください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 学年未選択は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['grade'] = '';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['grade' => '学年は、必ず指定してください。']);
    }

    /**
     * @test
     * @group student
    */
    public function メールアドレスが空白は可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['email'] = '';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertValid();
    }

    /**
     * @test
     * @group student
    */
    public function メールアドレスが51字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['email'] = str_repeat('a', 41) . '@gmail.com';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['email' => 'メールアドレスは、50文字以下にしてください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 無効なメールアドレスは不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['email'] = 'test@gmail.dom';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['email' => 'メールアドレスは、有効なメールアドレス形式で指定してください。']);
    }

    /**
     * @test
     * @group student
    */
    public function 備考が空白は可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['remarks'] = '';
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertValid();
    }

    /**
     * @test
     * @group student
    */
    public function 備考が201字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['remarks'] = str_repeat('a', 201);
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data)
            ->assertInValid(['remarks' => '備考は、200文字以下にしてください。']);
    }
}
