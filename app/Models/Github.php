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
        'forks',
        'stars',
        'watchers',
        'pull_request_date',
        'release_date',
        'open_pull_requests',
        'closed_pull_requests',
        'last_pull_merge_date',
    ];

    protected $casts = [
        'forks' => 'integer',
        'stars' => 'integer',
        'watchers' => 'integer',
        'open_pull_requests' => 'integer',
        'closed_pull_requests' => 'integer',
        'pull_request_date' => 'datetime',
        'release_date' => 'datetime',
        'last_pull_merge_date' => 'datetime',
    ];
}
