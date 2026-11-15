<?php

namespace Azuriom\Plugin\CreatorsIps\Http\Controllers\Api;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\CreatorsIps\Models\CreatorIp;
use Azuriom\Plugin\CreatorsIps\Models\CreatorIpPlayer;
use Azuriom\Plugin\CreatorsIps\Models\TrackedPlayer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JoinController extends Controller
{
    private const UUID_PATTERN = '/^[0-9a-f]{8}-?[0-9a-f]{4}-?[0-9a-f]{4}-?[0-9a-f]{4}-?[0-9a-f]{12}$/i';

    public function __invoke(Request $request): JsonResponse
    {
        if (! $this->hasValidToken($request)) {
            return response()->json(['message' => 'Invalid token.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'uuid' => ['required', 'string', 'regex:'.self::UUID_PATTERN],
            'name' => ['required', 'string', 'max:32'],
            'hostname' => ['nullable', 'string', 'max:512'],
            'first_join' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data.', 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $uuid = strtolower(str_replace('-', '', $data['uuid']));
        $playerName = $data['name'];
        $firstJoin = $data['first_join'] ?? null;
        $hostname = CreatorIp::normalizeHostname($data['hostname'] ?? null);
        $creatorIp = CreatorIp::findEnabledByHostname($hostname);

        DB::transaction(function () use ($uuid, $playerName, $firstJoin, $creatorIp) {
            $trackedPlayer = TrackedPlayer::where('uuid', $uuid)->lockForUpdate()->first();
            $isNewPlayer = $firstJoin !== null ? (bool) $firstJoin : $trackedPlayer === null;

            $this->markAsSeen($trackedPlayer, $uuid, $playerName);

            if ($creatorIp !== null) {
                $this->recordJoin($creatorIp, $uuid, $playerName, $isNewPlayer);
            }
        });

        return response()->json([
            'tracked' => $creatorIp !== null,
            'hostname' => $hostname,
        ]);
    }

    private function hasValidToken(Request $request): bool
    {
        $token = (string) setting('creatorsips.token');

        return $token !== '' && hash_equals($token, (string) $request->bearerToken());
    }

    private function markAsSeen(?TrackedPlayer $trackedPlayer, string $uuid, string $playerName): void
    {
        if ($trackedPlayer !== null) {
            $trackedPlayer->update(['name' => $playerName, 'last_seen_at' => now()]);

            return;
        }

        TrackedPlayer::create([
            'uuid' => $uuid,
            'name' => $playerName,
            'first_seen_at' => now(),
            'last_seen_at' => now(),
        ]);
    }

    private function recordJoin(CreatorIp $creatorIp, string $uuid, string $playerName, bool $isNewPlayer): void
    {
        $ipPlayer = CreatorIpPlayer::firstOrNew([
            'creator_ip_id' => $creatorIp->id,
            'player_uuid' => $uuid,
        ]);

        if (! $ipPlayer->exists) {
            $ipPlayer->is_new = $isNewPlayer;
            $ipPlayer->first_joined_at = now();
            $ipPlayer->joins_count = 0;
        }

        $ipPlayer->player_name = $playerName;
        $ipPlayer->last_joined_at = now();
        $ipPlayer->joins_count++;
        $ipPlayer->save();
    }
}
