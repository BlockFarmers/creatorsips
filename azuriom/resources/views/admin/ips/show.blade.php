@extends('admin.layouts.admin')

@section('title', trans('creatorsips::admin.ips.show', ['hostname' => $creatorIp->hostname]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <div class="h5 mb-1">
                    <code>{{ $creatorIp->hostname }}</code>

                    @unless($creatorIp->is_enabled)
                        <span class="badge bg-secondary">{{ trans('creatorsips::admin.fields.disabled_short') }}</span>
                    @endunless
                </div>

                <div>{{ trans('creatorsips::admin.fields.creator') }} : @include('creatorsips::admin.ips._creator')</div>

                @if($creatorIp->description)
                    <div class="text-muted small">{{ $creatorIp->description }}</div>
                @endif
            </div>

            <div>
                <a href="{{ route('creatorsips.admin.ips.edit', $creatorIp) }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i> {{ trans('creatorsips::admin.actions.edit') }}
                </a>
                @include('creatorsips::admin.ips._delete', [
                    'class' => 'btn btn-danger',
                    'label' => trans('creatorsips::admin.actions.delete'),
                ])
            </div>
        </div>
    </div>

    <div class="row">
        @include('creatorsips::admin.ips._stat', [
            'label' => trans('creatorsips::admin.stats.unique'),
            'value' => $stats->unique_players_count,
            'help' => trans('creatorsips::admin.stats.unique_help'),
        ])
        @include('creatorsips::admin.ips._stat', [
            'label' => trans('creatorsips::admin.stats.new'),
            'value' => $stats->new_players_count,
            'color' => 'success',
            'help' => trans('creatorsips::admin.stats.new_help'),
        ])
        @include('creatorsips::admin.ips._stat', [
            'label' => trans('creatorsips::admin.stats.active', ['days' => $activeDays]),
            'value' => $stats->active_players_count,
            'color' => 'info',
            'help' => trans('creatorsips::admin.stats.active_help', ['days' => $activeDays]),
        ])
        @include('creatorsips::admin.ips._stat', [
            'label' => trans('creatorsips::admin.stats.active_new', ['days' => $activeDays]),
            'value' => $stats->active_new_players_count.' ('.$retention.' %)',
            'color' => 'warning',
            'help' => trans('creatorsips::admin.stats.retention_help'),
        ])
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ trans('creatorsips::admin.players.title') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ trans('creatorsips::admin.players.name') }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.players.type') }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.players.first_joined') }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.players.last_joined') }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.players.joins') }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.players.last_seen') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($players as $player)
                            <tr>
                                <td>{{ $player->player_name }}</td>
                                <td>
                                    @if($player->is_new)
                                        <span class="badge bg-success">{{ trans('creatorsips::admin.players.new') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ trans('creatorsips::admin.players.existing') }}</span>
                                    @endif
                                </td>
                                <td>{{ $player->first_joined_at ? format_date($player->first_joined_at, true) : '-' }}</td>
                                <td>{{ $player->last_joined_at ? format_date($player->last_joined_at, true) : '-' }}</td>
                                <td>{{ $player->joins_count }}</td>
                                <td>
                                    @if($player->trackedPlayer?->last_seen_at)
                                        {{ $player->trackedPlayer->last_seen_at->diffForHumans() }}

                                        @if($player->isActive())
                                            <span class="badge bg-info">{{ trans('creatorsips::admin.players.active') }}</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">{{ trans('creatorsips::admin.players.empty') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $players->links() }}
        </div>
    </div>
@endsection
