@extends('admin.layouts.admin')

@section('title', trans('creatorsips::admin.ips.edit', ['hostname' => $creatorIp->hostname]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('creatorsips.admin.ips.update', $creatorIp) }}" method="POST">
                @method('PUT')
                @include('creatorsips::admin.ips._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('creatorsips::admin.actions.save') }}
                </button>
                <a href="{{ route('creatorsips.admin.ips.show', $creatorIp) }}" class="btn btn-secondary">
                    {{ trans('creatorsips::admin.actions.cancel') }}
                </a>
            </form>

            <div class="alert alert-info mt-3 mb-0">
                <i class="bi bi-info-circle"></i> {{ trans('creatorsips::admin.ips.edit_notice') }}
            </div>
        </div>
    </div>
@endsection
