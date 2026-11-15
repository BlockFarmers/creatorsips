@csrf

<div class="row g-3">
    <div class="mb-3 col-md-6">
        <label class="form-label" for="hostnameInput">{{ trans('creatorsips::admin.fields.hostname') }}</label>
        <input type="text" class="form-control @error('hostname') is-invalid @enderror" id="hostnameInput" name="hostname"
               value="{{ old('hostname', $creatorIp->hostname ?? '') }}" placeholder="name.example.com" required>

        @error('hostname')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror

        <div class="form-text">{{ trans('creatorsips::admin.fields.hostname_help') }}</div>
    </div>

    <div class="mb-3 col-md-6">
        <label class="form-label" for="creatorInput">{{ trans('creatorsips::admin.fields.creator') }}</label>
        <input type="text" class="form-control @error('creator') is-invalid @enderror" id="creatorInput" name="creator"
               value="{{ old('creator', isset($creatorIp) ? $creatorIp->creatorName() : '') }}" maxlength="32" required>

        @error('creator')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror

        <div class="form-text">{{ trans('creatorsips::admin.fields.creator_help') }}</div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="descriptionInput">{{ trans('creatorsips::admin.fields.description') }}</label>
    <input type="text" class="form-control @error('description') is-invalid @enderror" id="descriptionInput" name="description"
           value="{{ old('description', $creatorIp->description ?? '') }}" maxlength="255">

    @error('description')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="enabledSwitch" name="is_enabled" value="1"
           @checked(old('_token') !== null ? old('is_enabled') : ($creatorIp->is_enabled ?? true))>
    <label class="form-check-label" for="enabledSwitch">{{ trans('creatorsips::admin.fields.enabled') }}</label>
</div>
