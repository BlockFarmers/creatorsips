<div class="alert alert-{{ $type ?? 'info' }} d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div>
        <i class="bi bi-box-seam"></i> {{ $message }}
    </div>

    <a href="{{ $minecraftPluginUrl }}" class="btn btn-sm btn-primary" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-github"></i> {{ trans('creatorsips::admin.download.button') }}
    </a>
</div>
