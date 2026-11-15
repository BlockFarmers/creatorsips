@if($creatorIp->user)
    <a href="{{ route('admin.users.edit', $creatorIp->user) }}">{{ $creatorIp->user->name }}</a>
@else
    {{ $creatorIp->minecraft_name }}
    <span class="badge bg-warning text-dark" title="{{ trans('creatorsips::admin.ips.pending_help') }}" data-bs-toggle="tooltip">
        {{ trans('creatorsips::admin.ips.pending') }}
    </span>
@endif
