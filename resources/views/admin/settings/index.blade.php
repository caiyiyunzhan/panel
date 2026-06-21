@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'basic'])

@section('title')
    {{ __("admin.settings") }}
@endsection

@section('content-header')
    <h1>Panel {{ __("admin.settings") }}<small>Configure Pterodactyl to your liking.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">{{ __("admin.admin_label") }}</a></li>
        <li class="active">{{ __("admin.settings") }}</li>
    </ol>
@endsection

@section('content')
    @yield('settings::nav')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Panel {{ __("admin.settings") }}</h3>
                </div>
                <form action="{{ route('admin.settings') }}" method="POST">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">{{ __("admin.company_name") }}</label>
                                <div>
                                    <input type="text" class="form-control" name="app:name" value="{{ old('app:name', config('app.name')) }}" />
                                    <p class="text-muted"><small>{{ __("admin.company_name_desc") }}</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">{{ __("admin.require_2fa") }}</label>
                                <div>
                                    <div class="btn-group" data-toggle="buttons">
                                        @php
                                            $level = old('pterodactyl:auth:2fa_required', config('pterodactyl.auth.2fa_required'));
                                        @endphp
                                        <label class="btn btn-primary @if ($level == 0) active @endif">
                                            <input type="radio" name="pterodactyl:auth:2fa_required" autocomplete="off" value="0" @if ($level == 0) checked @endif> {{ __("admin.not_required") }}
                                        </label>
                                        <label class="btn btn-primary @if ($level == 1) active @endif">
                                            <input type="radio" name="pterodactyl:auth:2fa_required" autocomplete="off" value="1" @if ($level == 1) checked @endif> {{ __("admin.admin_only") }}
                                        </label>
                                        <label class="btn btn-primary @if ($level == 2) active @endif">
                                            <input type="radio" name="pterodactyl:auth:2fa_required" autocomplete="off" value="2" @if ($level == 2) checked @endif> {{ __("admin.all_users") }}
                                        </label>
                                    </div>
                                    <p class="text-muted"><small>{{ __("admin.require_2fa_desc") }}</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">{{ __("admin.default_language") }}</label>
                                <div>
                                    <select name="app:locale" class="form-control">
                                        @foreach($languages as $key => $value)
                                            <option value="{{ $key }}" @if(config('app.locale') === $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-muted"><small>{{ __("admin.default_language_desc") }}</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! csrf_field() !!}
                        <button type="submit" name="_method" value="PATCH" class="btn btn-sm btn-primary pull-right">{{ __("admin.save") }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
