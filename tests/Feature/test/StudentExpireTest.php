<?php

namespace Tests\Feature\test;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Auth;

class StudentExpireTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @test
     * @group student
    */
    public function 退会した生徒が一覧に表示されない()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['expired_date'] = '2022-5-1';
        $data['expired_flg'] = 1;
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data);
        $response = $this
            ->get(route('student.index'))
            ->assertDontSee($data['given_name']);
    }

    /**
     * @test
     * @group student
    */
    public function 退会した生徒が退会者の一覧に表示される()
    {
        $data = Student::factory()->make()->toArray();
        $response = $this->actingAs(User::find(1));
        $st = Auth::user()->students()->create($data);
        $data['expired_date'] = '2022-05-01';
        $data['expired_flg'] = 1;
        $response = $this
            ->put(route('student.update', ['student' => $st->id]), $data);
        $response = $this
            ->get(route('student.expired_index'))
            ->assertSee($data['given_name'])
            ->assertSee($data['expired_date']);
    }
}
