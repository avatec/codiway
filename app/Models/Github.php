<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Github extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'rank',
        'stats'
    ];

    protected $requiered = [
        'name',
        'url',
        'rank'
    ];
}
