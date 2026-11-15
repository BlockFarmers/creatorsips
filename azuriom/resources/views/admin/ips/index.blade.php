@extends('admin.layouts.admin')

@section('title', trans('creatorsips::admin.ips.title'))

@section('content')
    @unless($hasReceivedJoins)
        @include('creatorsips::admin._download', [
            'type' => 'warning',
            'message' => trans('creatorsips::admin.download.no_joins'),
        ])
    @endunless

    <div class="row">
        @include('creatorsips::admin.ips._stat', [
            'label' => trans('creatorsips::admin.stats.unique'),
            'value' => $totals['unique'],
        ])
        @include('creatorsips::admin.ips._stat', [
            'label' => trans('creatorsips::admin.stats.new'),
            'value' => $totals['new'],
            'color' => 'success',
        ])
        @include('creatorsips::admin.ips._stat', [
            'label' => trans('creatorsips::admin.stats.active', ['days' => $activeDays]),
            'value' => $totals['active'],
            'color' => 'info',
        ])
        @include('creatorsips::admin.ips._stat', [
            'label' => trans('creatorsips::admin.stats.active_new', ['days' => $activeDays]),
            'value' => $totals['active_new'],
            'color' => 'warning',
        ])
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ trans('creatorsips::admin.fields.hostname') }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.fields.creator') }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.stats.unique') }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.stats.new') }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.stats.active', ['days' => $activeDays]) }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.stats.active_new', ['days' => $activeDays]) }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.fields.status') }}</th>
                            <th scope="col">{{ trans('creatorsips::admin.fields.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($creatorIps as $creatorIp)
                            <tr>
                                <td>
                                    <a href="{{ route('creatorsips.admin.ips.show', $creatorIp) }}"><code>{{ $creatorIp->hostname }}</code></a>

                                    @if($creatorIp->description)
                                        <div class="small text-muted">{{ $creatorIp->description }}</div>
                                    @endif
                                </td>
                                <td>@include('creatorsips::admin.ips._creator')</td>
                                <td>{{ $creatorIp->unique_players_count }}</td>
                                <td>{{ $creatorIp->new_players_count }}</td>
                                <td>{{ $creatorIp->active_players_count }}</td>
                                <td>{{ $creatorIp->active_new_players_count }}</td>
                                <td>
                                    @if($creatorIp->is_enabled)
                                        <span class="badge bg-success">{{ trans('creatorsips::admin.fields.enabled_short') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ trans('creatorsips::admin.fields.disabled_short') }}</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('creatorsips.admin.ips.show', $creatorIp) }}" class="mx-1"
                                       title="{{ trans('creatorsips::admin.actions.stats') }}" data-bs-toggle="tooltip">
                                        <i class="bi bi-bar-chart"></i>
                                    </a>
                                    <a href="{{ route('creatorsips.admin.ips.edit', $creatorIp) }}" class="mx-1"
                                       title="{{ trans('creatorsips::admin.actions.edit') }}" data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @include('creatorsips::admin.ips._delete')
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">{{ trans('creatorsips::admin.ips.empty') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('creatorsips.admin.ips.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> {{ trans('creatorsips::admin.ips.create') }}
            </a>
        </div>
    </div>
@endsection
