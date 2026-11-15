@extends('admin.layouts.admin')

@section('title', trans('creatorsips::admin.ips.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('creatorsips.admin.ips.store') }}" method="POST">
                @include('creatorsips::admin.ips._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('creatorsips::admin.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
