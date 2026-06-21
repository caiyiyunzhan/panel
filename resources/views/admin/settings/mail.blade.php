@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'mail'])

@section('title')
    {{ __("admin.mail_settings") }}
@endsection

@section('content-header')
    <h1>{{ __("admin.mail_settings") }}<small>Configure how Pterodactyl should handle sending emails.</small></h1>
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
                    <h3 class="box-title">{{ __("admin.mail_settings") }}</h3>
                </div>
                @if($disabled)
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-info no-margin-bottom">{{ __("admin.mail_interface_notice") }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <form>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">{{ __("admin.smtp_host") }}</label>
                                    <div>
                                        <input required type="text" class="form-control" name="mail:mailers:smtp:host" value="{{ old('mail:mailers:smtp:host', config('mail.mailers.smtp.host')) }}" />
                                        <p class="text-muted small">{{ __("admin.smtp_host_desc") }}</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label">{{ __("admin.smtp_port") }}</label>
                                    <div>
                                        <input required type="number" class="form-control" name="mail:mailers:smtp:port" value="{{ old('mail:mailers:smtp:port', config('mail.mailers.smtp.port')) }}" />
                                        <p class="text-muted small">{{ __("admin.smtp_port_desc") }}</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">{{ __("admin.encryption") }}</label>
                                    <div>
                                        @php
                                            $encryption = old('mail:mailers:smtp:encryption', config('mail.mailers.smtp.encryption'));
                                        @endphp
                                        <select name="mail:mailers:smtp:encryption" class="form-control">
                                            <option value="" @if($encryption === '') selected @endif>{{ __("admin.none") }}</option>
                                            <option value="tls" @if($encryption === 'tls') selected @endif>{{ __("admin.tls") }}</option>
                                            <option value="ssl" @if($encryption === 'ssl') selected @endif>{{ __("admin.ssl") }}</option>
                                        </select>
                                        <p class="text-muted small">{{ __("admin.encryption_desc") }}</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">{{ __("admin.username") }} <span class="field-optional"></span></label>
                                    <div>
                                        <input type="text" class="form-control" name="mail:mailers:smtp:username" value="{{ old('mail:mailers:smtp:username', config('mail.mailers.smtp.username')) }}" />
                                        <p class="text-muted small">{{ __("admin.smtp_username_desc") }}</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">{{ __("admin.password") }} <span class="field-optional"></span></label>
                                    <div>
                                        <input type="password" class="form-control" name="mail:mailers:smtp:password"/>
                                        <p class="text-muted small">The password to use in conjunction with the SMTP username. Leave blank to continue using the existing password. To set the password to an empty value enter <code>!e</code> into the field.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <hr />
                                <div class="form-group col-md-6">
                                    <label class="control-label">{{ __("admin.mail_from") }}</label>
                                    <div>
                                        <input required type="email" class="form-control" name="mail:from:address" value="{{ old('mail:from:address', config('mail.from.address')) }}" />
                                        <p class="text-muted small">{{ __("admin.mail_from_desc") }}</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">{{ __("admin.mail_from_name") }} <span class="field-optional"></span></label>
                                    <div>
                                        <input type="text" class="form-control" name="mail:from:name" value="{{ old('mail:from:name', config('mail.from.name')) }}" />
                                        <p class="text-muted small">{{ __("admin.mail_from_name_desc") }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            {{ csrf_field() }}
                            <div class="pull-right">
                                <button type="button" id="testButton" class="btn btn-sm btn-success">{{ __("admin.test") }}</button>
                                <button type="button" id="saveButton" class="btn btn-sm btn-primary">{{ __("admin.save") }}</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent

    <script>
        function saveSettings() {
            return $.ajax({
                method: 'PATCH',
                url: '/admin/settings/mail',
                contentType: 'application/json',
                data: JSON.stringify({
                    'mail:mailers:smtp:host': $('input[name="mail:mailers:smtp:host"]').val(),
                    'mail:mailers:smtp:port': $('input[name="mail:mailers:smtp:port"]').val(),
                    'mail:mailers:smtp:encryption': $('select[name="mail:mailers:smtp:encryption"]').val(),
                    'mail:mailers:smtp:username': $('input[name="mail:mailers:smtp:username"]').val(),
                    'mail:mailers:smtp:password': $('input[name="mail:mailers:smtp:password"]').val(),
                    'mail:from:address': $('input[name="mail:from:address"]').val(),
                    'mail:from:name': $('input[name="mail:from:name"]').val()
                }),
                headers: { 'X-CSRF-Token': $('input[name="_token"]').val() }
            }).fail(function (jqXHR) {
                showErrorDialog(jqXHR, 'save');
            });
        }

        function testSettings() {
            swal({
                type: 'info',
                title: 'Test {{ __("admin.mail_settings") }}',
                text: '{{ __("admin.test_mail_confirm_text") }}',
                showCancelButton: true,
                confirmButtonText: '{{ __("admin.test") }}',
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                $.ajax({
                    method: 'POST',
                    url: '/admin/settings/mail/test',
                    headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
                }).fail(function (jqXHR) {
                    showErrorDialog(jqXHR, 'test');
                }).done(function () {
                    swal({
                        title: '{{ __("admin.success") }}',
                        text: '{{ __("admin.test_mail_success") }}',
                        type: 'success'
                    });
                });
            });
        }

        function saveAndTestSettings() {
            saveSettings().done(testSettings);
        }

        function showErrorDialog(jqXHR, verb) {
            console.error(jqXHR);
            var errorText = '';
            if (!jqXHR.responseJSON) {
                errorText = jqXHR.responseText;
            } else if (jqXHR.responseJSON.error) {
                errorText = jqXHR.responseJSON.error;
            } else if (jqXHR.responseJSON.errors) {
                $.each(jqXHR.responseJSON.errors, function (i, v) {
                    if (v.detail) {
                        errorText += v.detail + ' ';
                    }
                });
            }

            swal({
                title: '{{ __("admin.whoops") }}',
                text: '{{ __("admin.mail_error_prefix") }}' + verb + '{{ __("admin.mail_error_suffix") }}' + errorText,
                type: 'error'
            });
        }

        $(document).ready(function () {
            $('#testButton').on('click', saveAndTestSettings);
            $('#saveButton').on('click', function () {
                saveSettings().done(function () {
                    swal({
                        title: '{{ __("admin.success") }}',
                        text: '{{ __("admin.mail_save_success") }}',
                        type: 'success'
                    });
                });
            });
        });
    </script>
@endsection
