<?php

namespace Azuriom\Plugin\CreatorsIps\Http\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\CreatorsIps\Http\Requests\CreatorIpRequest;
use Azuriom\Plugin\CreatorsIps\Models\CreatorIp;
use Azuriom\Plugin\CreatorsIps\Models\TrackedPlayer;

class CreatorIpController extends Controller
{
    public function index()
    {
        CreatorIp::linkAllPending();

        $creatorIps = CreatorIp::with('user')->withStats()->orderBy('hostname')->get();

        return view('creatorsips::admin.ips.index', [
            'creatorIps' => $creatorIps,
            'activeDays' => CreatorIp::activeDays(),
            'hasReceivedJoins' => TrackedPlayer::exists(),
            'minecraftPluginUrl' => config('creatorsips.minecraft_plugin_url'),
            'totals' => [
                'unique' => $creatorIps->sum('unique_players_count'),
                'new' => $creatorIps->sum('new_players_count'),
                'active' => $creatorIps->sum('active_players_count'),
                'active_new' => $creatorIps->sum('active_new_players_count'),
            ],
        ]);
    }

    public function create()
    {
        return view('creatorsips::admin.ips.create');
    }

    public function store(CreatorIpRequest $request)
    {
        $creatorIp = CreatorIp::create($request->toModelAttributes());

        return to_route('creatorsips.admin.ips.show', $creatorIp)
            ->with('success', trans('creatorsips::admin.ips.created'));
    }

    public function show(CreatorIp $creatorIp)
    {
        $stats = CreatorIp::withStats()->findOrFail($creatorIp->id);

        $retention = $stats->new_players_count > 0
            ? round($stats->active_new_players_count / $stats->new_players_count * 100)
            : 0;

        $players = $creatorIp->players()
            ->with('trackedPlayer')
            ->orderByDesc('first_joined_at')
            ->paginate(25);

        return view('creatorsips::admin.ips.show', [
            'creatorIp' => $creatorIp->load('user'),
            'stats' => $stats,
            'retention' => $retention,
            'players' => $players,
            'activeDays' => CreatorIp::activeDays(),
        ]);
    }

    public function edit(CreatorIp $creatorIp)
    {
        return view('creatorsips::admin.ips.edit', [
            'creatorIp' => $creatorIp->load('user'),
        ]);
    }

    public function update(CreatorIpRequest $request, CreatorIp $creatorIp)
    {
        $creatorIp->update($request->toModelAttributes());

        return to_route('creatorsips.admin.ips.show', $creatorIp)
            ->with('success', trans('creatorsips::admin.ips.updated'));
    }

    public function destroy(CreatorIp $creatorIp)
    {
        $creatorIp->delete();

        return to_route('creatorsips.admin.ips.index')
            ->with('success', trans('creatorsips::admin.ips.deleted'));
    }
}
