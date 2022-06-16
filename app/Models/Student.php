<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'registered_date',
        'expired_flg',
        'expired_date',
        'class_name',
        'family_name',
        'given_name',
        'family_name_kana',
        'given_name_kana',
        'gender',
        'grade',
        'birth_date',
        'school_attended',
        'family_group',
        'guardian_family_name',
        'guardian_given_name',
        'guardian_family_name_kana',
        'guardian_given_name_kana',
        'phone1',
        'phone1_relationship',
        'phone2',
        'phone2_relationship',
        'email',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student_group()
    {
        return $this->belongsTo(StudentGroup::class);
    }
}
