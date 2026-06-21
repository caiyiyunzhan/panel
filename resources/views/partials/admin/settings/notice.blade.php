@section('settings::notice')
    @if(config('pterodactyl.load_environment_only', false))
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger">
                    {{ __('admin.settings_env_notice') }}
                </div>
            </div>
        </div>
    @endif
@endsection
