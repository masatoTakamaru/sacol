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
        'email',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

}
