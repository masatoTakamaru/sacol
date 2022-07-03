<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qprice extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'grade',
        'qprice',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
