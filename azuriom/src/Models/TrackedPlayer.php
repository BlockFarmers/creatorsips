<?php

namespace Azuriom\Plugin\CreatorsIps\Models;

use Illuminate\Database\Eloquent\Model;

class TrackedPlayer extends Model
{
    protected $table = 'creatorsips_players';

    protected $fillable = [
        'uuid',
        'name',
        'first_seen_at',
        'last_seen_at',
    ];

    protected $casts = [
        'first_seen_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];
}
