@extends('admin.layouts.admin')

@section('title', trans('creatorsips::admin.settings.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ trans('creatorsips::admin.settings.minecraft') }}</h5>
        </div>
        <div class="card-body">
            @include('creatorsips::admin._download', [
                'message' => trans('creatorsips::admin.download.info'),
            ])

            <p>{{ trans('creatorsips::admin.settings.minecraft_help') }}</p>

            <ul class="small">
                <li>{{ trans('creatorsips::admin.settings.path_server') }} <code>plugins/CreatorsIPs/config.properties</code></li>
                <li>{{ trans('creatorsips::admin.settings.path_velocity') }} <code>plugins/creatorsips/config.properties</code></li>
            </ul>

            <textarea class="form-control font-monospace mb-2" id="minecraftConfig" rows="2" readonly
                      onclick="this.select()">site-url={{ $siteUrl }}
token={{ $token }}</textarea>

            <button type="button" class="btn btn-secondary btn-sm mb-3"
                    data-copied="{{ trans('creatorsips::admin.settings.copied') }}"
                    onclick="navigator.clipboard.writeText(document.getElementById('minecraftConfig').value).then(() => { this.innerText = this.dataset.copied; })">
                <i class="bi bi-clipboard"></i> {{ trans('creatorsips::admin.settings.copy') }}
            </button>

            <p class="small text-muted mb-3">
                {{ trans('creatorsips::admin.settings.endpoint') }} <code>{{ $endpoint }}</code>
            </p>

            <form action="{{ route('creatorsips.admin.settings.token') }}" method="POST"
                  data-message="{{ trans('creatorsips::admin.settings.regenerate_confirm') }}"
                  onsubmit="return confirm(this.dataset.message)">
                @csrf

                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-arrow-repeat"></i> {{ trans('creatorsips::admin.settings.regenerate') }}
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ trans('creatorsips::admin.settings.stats') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('creatorsips.admin.settings.save') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="activeDaysInput">{{ trans('creatorsips::admin.settings.active_days') }}</label>
                    <input type="number" min="1" max="365" class="form-control @error('active_days') is-invalid @enderror"
                           id="activeDaysInput" name="active_days" value="{{ old('active_days', $activeDays) }}" required>

                    @error('active_days')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <div class="form-text">{{ trans('creatorsips::admin.settings.active_days_help') }}</div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('creatorsips::admin.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
