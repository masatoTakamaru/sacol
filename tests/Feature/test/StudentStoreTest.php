<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;

class StudentStoreTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /** @test */
    public function 生徒を登録したら一覧にリダイレクトされる()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertRedirect(route('student.index'));
    }

    /** @test */
    public function 登録した生徒が一覧に表示される()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data);

        $response = $this
            ->get(route('student.index'))
            ->assertSee($data['family_name']);
    }
    
    /** @test */
    public function 生徒姓が空白は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['family_name'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['family_name' => '生徒姓は、必ず指定してください。']);
    }

    /** @test */
    public function 生徒姓が21字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['family_name'] = str_repeat('a', 21);
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['family_name' => '生徒姓は、20文字以下にしてください。']);
    }

    /** @test */
    public function 生徒名が空白は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['given_name'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['given_name' => '生徒名は、必ず指定してください。']);
    }

    /** @test */
    public function 生徒名が21字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['given_name'] = str_repeat('a', 21);
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['given_name' => '生徒名は、20文字以下にしてください。']);
    }

    /** @test */
    public function 生徒姓フリガナが空白は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['family_name_kana'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['family_name_kana' => '生徒姓フリガナは、必ず指定してください。']);
    }

    /** @test */
    public function 生徒姓フリガナが21字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['family_name_kana'] = str_repeat('ア', 21);
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['family_name_kana' => '生徒姓フリガナは、20文字以下にしてください。']);
    }

    /** @test */
    public function 生徒姓フリガナが全角カタカナ以外は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['family_name_kana'] = 'a';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['family_name_kana' => '全角カタカナで入力してください。']);
    }

    /** @test */
    public function 生徒名フリガナが空白は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['given_name_kana'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['given_name_kana' => '生徒名フリガナは、必ず指定してください。']);
    }

    /** @test */
    public function 生徒名フリガナが21字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['given_name_kana'] = str_repeat('ア', 21);
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['given_name_kana' => '生徒名フリガナは、20文字以下にしてください。']);
    }

    /** @test */
    public function 生徒名フリガナが全角カタカナ以外は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['given_name_kana'] = 'a';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['given_name_kana' => '全角カタカナで入力してください。']);
    }

    /** @test */
    public function 性別未選択は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['gender'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['gender' => '性別は、必ず指定してください。']);
    }

    /** @test */
    public function 学年未選択は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['grade'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['grade' => '学年は、必ず指定してください。']);
    }

    /** @test */
    public function メールアドレスが空白は可()
    {
        $data = Student::factory()->make()->toArray();
        $data['email'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertValid();
    }

    /** @test */
    public function メールアドレスが51字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['email'] = str_repeat('a', 41) . '@gmail.com';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['email' => 'メールアドレスは、50文字以下にしてください。']);
    }

    /** @test */
    public function 無効なメールアドレスは不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['email'] = 'test@gmail.dom';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['email' => 'メールアドレスは、有効なメールアドレス形式で指定してください。']);
    }

    /** @test */
    public function 備考が空白は可()
    {
        $data = Student::factory()->make()->toArray();
        $data['remarks'] = '';
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertValid();
    }

    /** @test */
    public function 備考が201字以上は不可()
    {
        $data = Student::factory()->make()->toArray();
        $data['remarks'] = str_repeat('a', 201);
        $response = $this->actingAs(User::find(1))
            ->post(route('student.store'), $data)
            ->assertInValid(['remarks' => '備考は、200文字以下にしてください。']);
    }
}
