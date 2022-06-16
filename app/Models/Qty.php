<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qty extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'grade',
        'qty',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
