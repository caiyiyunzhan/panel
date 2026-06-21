@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: {{ __("admin.delete_server") }}
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>{{ __("admin.delete_server_desc") }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Servers</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">{{ __("admin.delete") }}</li>
    </ol>
@endsection

@section('content')
@include('admin.servers.partials.navigation')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __("admin.safely_delete_server") }}</h3>
            </div>
            <div class="box-body">
                <p>{{ __("admin.safe_delete_desc") }}</p>
                <p class="text-danger small">{{ __("admin.delete_irreversible_warning") }}</p>
            </div>
            <div class="box-footer">
                <form id="deleteform" action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <button id="deletebtn" class="btn btn-danger">{{ __("admin.safely_delete_this_server") }}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __("admin.force_delete_server") }}</h3>
            </div>
            <div class="box-body">
                <p>{{ __("admin.force_delete_desc") }}</p>
                <p class="text-danger small">{{ __("admin.force_delete_warning") }}</p>
            </div>
            <div class="box-footer">
                <form id="forcedeleteform" action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="force_delete" value="1" />
                    <button id="forcedeletebtn"" class="btn btn-danger">{{ __("admin.forcibly_delete_this_server") }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#deletebtn').click(function (event) {
        event.preventDefault();
        swal({
            title: '',
            type: 'warning',
            text: '{{ __("admin.delete_confirm_text") }}',
            showCancelButton: true,
            confirmButtonText: '{{ __("admin.delete") }}',
            confirmButtonColor: '#d9534f',
            closeOnConfirm: false
        }, function () {
            $('#deleteform').submit()
        });
    });

    $('#forcedeletebtn').click(function (event) {
        event.preventDefault();
        swal({
            title: '',
            type: 'warning',
            text: '{{ __("admin.delete_confirm_text") }}',
            showCancelButton: true,
            confirmButtonText: '{{ __("admin.delete") }}',
            confirmButtonColor: '#d9534f',
            closeOnConfirm: false
        }, function () {
            $('#forcedeleteform').submit()
        });
    });
    </script>
@endsection
