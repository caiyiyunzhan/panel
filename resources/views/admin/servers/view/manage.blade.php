@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: {{ __("admin.server_management") }}
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>{{ __("admin.server_management_desc") }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Servers</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">{{ __("admin.manage") }}</li>
    </ol>
@endsection

@section('content')
    @include('admin.servers.partials.navigation')
    <div class="row equal-height">
        <div class="col-sm-4">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __("admin.reinstall_server") }}</h3>
                </div>
                <div class="box-body">
                    <p>{{ __("admin.reinstall_server_warning") }}</p>
                </div>
                <div class="box-footer">
                    @if($server->isInstalled())
                        <form action="{{ route('admin.servers.view.manage.reinstall', $server->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-danger">{{ __("admin.reinstall_server") }}</button>
                        </form>
                    @else
                        <button class="btn btn-danger disabled">{{ __("admin.server_must_install_to_reinstall") }}</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __("admin.install_status") }}</h3>
                </div>
                <div class="box-body">
                    <p>{{ __("admin.install_status_desc") }}</p>
                </div>
                <div class="box-footer">
                    <form action="{{ route('admin.servers.view.manage.toggle', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-primary">{{ __("admin.toggle_install_status") }}</button>
                    </form>
                </div>
            </div>
        </div>

        @if(! $server->isSuspended())
            <div class="col-sm-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __("admin.suspend_server") }}</h3>
                    </div>
                    <div class="box-body">
                        <p>{{ __("admin.suspend_server_desc") }}</p>
                    </div>
                    <div class="box-footer">
                        <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="action" value="suspend" />
                            <button type="submit" class="btn btn-warning @if(! is_null($server->transfer)) disabled @endif">{{ __("admin.suspend_server") }}</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="col-sm-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __("admin.unsuspend_server") }}</h3>
                    </div>
                    <div class="box-body">
                        <p>{{ __("admin.unsuspend_server_desc") }}</p>
                    </div>
                    <div class="box-footer">
                        <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="action" value="unsuspend" />
                            <button type="submit" class="btn btn-success">{{ __("admin.unsuspend_server") }}</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if(is_null($server->transfer))
            <div class="col-sm-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __("admin.transfer_server") }}</h3>
                    </div>
                    <div class="box-body">
                        <p>
                            {{ __("admin.transfer") }} this server to another node connected to this panel.
                            <strong>Warning!</strong> This feature has not been fully tested and may have bugs.
                        </p>
                    </div>

                    <div class="box-footer">
                        @if($can{{ __("admin.transfer") }})
                            <button class="btn btn-success" data-toggle="modal" data-target="#transferServerModal">{{ __("admin.transfer_server") }}</button>
                        @else
                            <button class="btn btn-success disabled">{{ __("admin.transfer_server") }}</button>
                            <p style="padding-top: 1rem;">{{ __("admin.transfer") }}ring a server requires more than one node to be configured on your panel.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="col-sm-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __("admin.transfer_server") }}</h3>
                    </div>
                    <div class="box-body">
                        <p>
                            This server is currently being transferred to another node.
                            {{ __("admin.transfer") }} was initiated at <strong>{{ $server->transfer->created_at }}</strong>
                        </p>
                    </div>

                    <div class="box-footer">
                        <button class="btn btn-success disabled">{{ __("admin.transfer_server") }}</button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="transferServerModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.servers.view.manage.transfer', $server->id) }}" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{{ __("admin.transfer_server") }}</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="pNodeId">{{ __("admin.node") }}</label>
                                <select name="node_id" id="pNodeId" class="form-control">
                                    @foreach($locations as $location)
                                        <optgroup label="{{ $location->long }} ({{ $location->short }})">
                                            @foreach($location->nodes as $node)

                                                @if($node->id != $server->node_id)
                                                    <option value="{{ $node->id }}"
                                                            @if($location->id === old('location_id')) selected @endif
                                                    >{{ $node->name }}</option>
                                                @endif

                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <p class="small text-muted no-margin">{{ __("admin.transfer_node_desc") }}</p>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="pAllocation">{{ __("admin.default_allocation") }}</label>
                                <select name="allocation_id" id="pAllocation" class="form-control"></select>
                                <p class="small text-muted no-margin">{{ __("admin.default_allocation_desc") }}</p>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="pAllocationAdditional">{{ __("admin.additional_allocations") }}</label>
                                <select name="allocation_additional[]" id="pAllocationAdditional" class="form-control" multiple></select>
                                <p class="small text-muted no-margin">{{ __("admin.additional_allocations_desc") }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        {!! csrf_field() !!}
                        <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">{{ __("admin.cancel") }}</button>
                        <button type="submit" class="btn btn-success btn-sm">{{ __("admin.confirm") }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}

    @if($can{{ __("admin.transfer") }})
        {!! Theme::js('js/admin/server/transfer.js') !!}
    @endif
@endsection
