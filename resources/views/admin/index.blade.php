@extends('layouts.admin')

@section('title')
    {{ __('admin.administration') }}
@endsection

@section('content-header')
    <h1>{{ __('admin.admin_overview') }}<small>{{ __('admin.quick_glance') }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">{{ __('admin.admin_label') }}</a></li>
        <li class="active">{{ __('admin.overview') }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box
            @if($version->isLatestPanel())
                box-success
            @else
                box-danger
            @endif
        ">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('admin.system_info') }}</h3>
            </div>
            <div class="box-body">
                @if ($version->isLatestPanel())
                    {{ __('admin.running_version') }} <code>{{ config('app.version') }}</code>. {{ __('admin.panel_up_to_date') }}
                @else
                    {{ __('admin.panel_not_up_to_date') }} <a href="https://github.com/Pterodactyl/Panel/releases/v{{ $version->getPanel() }}" target="_blank"><code>{{ $version->getPanel() }}</code></a> {{ __('admin.running_version') }} <code>{{ config('app.version') }}</code>. <a href="https://pterodactyl.io/panel/1.0/updating.html">{{ __('admin.update_instructions') }}</a>.
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-3 text-center">
        <a href="{{ $version->getDiscord() }}"><button class="btn btn-warning" style="width:100%;"><i class="fa fa-fw fa-support"></i> {{ __('admin.get_help') }} <small>{{ __('admin.via_discord') }}</small></button></a>
    </div>
    <div class="col-xs-6 col-sm-3 text-center">
        <a href="https://pterodactyl.io"><button class="btn btn-primary" style="width:100%;"><i class="fa fa-fw fa-link"></i> {{ __('admin.documentation') }}</button></a>
    </div>
    <div class="clearfix visible-xs-block">&nbsp;</div>
    <div class="col-xs-6 col-sm-3 text-center">
        <a href="https://github.com/pterodactyl/panel"><button class="btn btn-primary" style="width:100%;"><i class="fa fa-fw fa-support"></i> {{ __('admin.github') }}</button></a>
    </div>
    <div class="col-xs-6 col-sm-3 text-center">
        <a href="{{ $version->getDonations() }}"><button class="btn btn-success" style="width:100%;"><i class="fa fa-fw fa-money"></i> {{ __('admin.support_project') }}</button></a>
    </div>
</div>
@endsection