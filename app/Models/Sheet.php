<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'enrollment',
        'sales',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
