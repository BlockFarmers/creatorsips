<?php

namespace Azuriom\Plugin\CreatorsIps\Models;

use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CreatorIp extends Model
{
    protected $table = 'creatorsips_ips';

    protected $fillable = [
        'hostname',
        'user_id',
        'minecraft_name',
        'description',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(CreatorIpPlayer::class);
    }

    public function creatorName(): string
    {
        return $this->user?->name ?? $this->minecraft_name ?? '?';
    }

    public function scopeWithStats(Builder $query): Builder
    {
        $activeSince = now()->subDays(static::activeDays());

        $onlyActive = fn ($players) => $players->whereHas(
            'trackedPlayer',
            fn ($trackedPlayer) => $trackedPlayer->where('last_seen_at', '>=', $activeSince)
        );

        return $query->withCount([
            'players as unique_players_count',
            'players as new_players_count' => fn ($players) => $players->where('is_new', true),
            'players as active_players_count' => $onlyActive,
            'players as active_new_players_count' => fn ($players) => $onlyActive($players->where('is_new', true)),
        ]);
    }

    public static function activeDays(): int
    {
        return max(1, (int) setting('creatorsips.active_days', 7));
    }

    public static function findEnabledByHostname(?string $hostname): ?self
    {
        if ($hostname === null) {
            return null;
        }

        return static::where('hostname', $hostname)->where('is_enabled', true)->first();
    }

    public static function normalizeHostname(?string $hostname): ?string
    {
        if ($hostname === null) {
            return null;
        }

        $hostname = Str::before($hostname, "\0");
        $hostname = Str::before($hostname, '///');
        $hostname = strtolower(trim($hostname));
        $hostname = preg_replace('/:\d+$/', '', $hostname);
        $hostname = rtrim($hostname, '.');

        return $hostname !== '' ? $hostname : null;
    }

    public static function findUserByName(string $name): ?User
    {
        return User::whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->first();
    }

    public static function linkPendingTo(User $user): void
    {
        static::whereNull('user_id')
            ->whereRaw('LOWER(minecraft_name) = ?', [mb_strtolower($user->name)])
            ->update(['user_id' => $user->id, 'minecraft_name' => $user->name]);
    }

    public static function linkAllPending(): void
    {
        $pendingIps = static::whereNull('user_id')->whereNotNull('minecraft_name')->get();

        foreach ($pendingIps as $creatorIp) {
            $user = static::findUserByName($creatorIp->minecraft_name);

            if ($user !== null) {
                $creatorIp->update(['user_id' => $user->id, 'minecraft_name' => $user->name]);
            }
        }
    }
}
