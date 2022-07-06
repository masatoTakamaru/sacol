<?php

namespace Tests\Feature\test;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Auth;

class StudentDestroyTest extends TestCase
{
    /** @test */
    public function 生徒を削除したら一覧にリダイレクトされる()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $response = $this
            ->delete(route('student.destroy', ['student' => $st->id]))
            ->assertRedirect(route('student.index'));
    }

    /** @test */
    public function 削除した生徒が一覧に表示されない()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $response = $this
            ->delete(route('student.destroy', ['student' => $st->id]));
        $response = $this
            ->get(route('student.index'))
            ->assertDontSee($data['given_name']);
    }
}
