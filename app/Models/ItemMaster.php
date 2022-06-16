<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'category',
        'name',
        'price',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
