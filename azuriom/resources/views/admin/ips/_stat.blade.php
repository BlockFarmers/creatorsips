<div class="col-md-6 col-xl-3 mb-4">
    <div class="card shadow h-100">
        <div class="card-body">
            <div class="text-uppercase small fw-bold text-{{ $color ?? 'primary' }} mb-1">{{ $label }}</div>
            <div class="h4 mb-0 fw-bold">{{ $value }}</div>

            @isset($help)
                <div class="small text-muted mt-1">{{ $help }}</div>
            @endisset
        </div>
    </div>
</div>
