<?php

namespace Azuriom\Plugin\CreatorsIps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreatorIpPlayer extends Model
{
    protected $table = 'creatorsips_ip_players';

    protected $fillable = [
        'creator_ip_id',
        'player_uuid',
        'player_name',
        'is_new',
        'joins_count',
        'first_joined_at',
        'last_joined_at',
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'joins_count' => 'integer',
        'first_joined_at' => 'datetime',
        'last_joined_at' => 'datetime',
    ];

    public function creatorIp(): BelongsTo
    {
        return $this->belongsTo(CreatorIp::class);
    }

    public function trackedPlayer(): BelongsTo
    {
        return $this->belongsTo(TrackedPlayer::class, 'player_uuid', 'uuid');
    }

    public function isActive(): bool
    {
        $lastSeenAt = $this->trackedPlayer?->last_seen_at;

        return $lastSeenAt !== null && $lastSeenAt->gte(now()->subDays(CreatorIp::activeDays()));
    }
}
