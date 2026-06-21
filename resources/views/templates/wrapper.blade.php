<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'Pterodactyl') }}</title>

        @section('meta')
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <meta name="robots" content="noindex">
            <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
            <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
            <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
            <link rel="manifest" href="/favicons/manifest.json">
            <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
            <link rel="shortcut icon" href="/favicons/favicon.ico">
            <meta name="msapplication-config" content="/favicons/browserconfig.xml">
            <meta name="theme-color" content="#0e4688">
        @show

        @section('user-data')
            @if(!is_null(Auth::user()))
                <script>
                    window.PterodactylUser = {!! json_encode(Auth::user()->toVueObject()) !!};
                </script>
            @endif
            @if(!empty($siteConfiguration))
                <script>
                    window.SiteConfiguration = {!! json_encode($siteConfiguration) !!};
                </script>
            @endif
        @show

        
        <script>
            (function() {
                console.log('[DIAG] SiteConfiguration.locale:', window.SiteConfiguration ? window.SiteConfiguration.locale : 'NOT SET');
                console.log('[DIAG] navigator.language:', navigator.language);
                // Wait for i18next to init
                var checkCount = 0;
                var interval = setInterval(function() {
                    checkCount++;
                    if (window.i18n) {
                        console.log('[DIAG] i18n.language:', window.i18n.language);
                        console.log('[DIAG] i18n.languages:', window.i18n.languages);
                        console.log('[DIAG] i18n.isInitialized:', window.i18n.isInitialized);
                        clearInterval(interval);
                    } else if (checkCount > 30) {
                        console.log('[DIAG] i18n not found after 15 seconds');
                        clearInterval(interval);
                    }
                }, 500);
            })();
        </script>
@yield('assets')

        @include('layouts.scripts')
    
<script>
window.__DIAG = { errors: [], i18nStatus: 'initializing' };
window.addEventListener('error', function(e) {
    window.__DIAG.errors.push({ msg: e.message, src: e.filename, line: e.lineno, col: e.colno });
    console.error('[DIAG] JS ERROR:', e.message, 'at', e.filename + ':' + e.lineno);
});
window.addEventListener('unhandledrejection', function(e) {
    window.__DIAG.errors.push({ msg: 'Promise rejection: ' + (e.reason ? e.reason.message : 'unknown'), type: 'promise' });
    console.error('[DIAG] UNHANDLED REJECTION:', e.reason);
});
// Check if i18n exists and report
var checkI18n = setInterval(function() {
    if (typeof i18n !== 'undefined' && i18n) {
        window.__DIAG.i18nStatus = 'i18n found - language: ' + i18n.language + ' - initialized: ' + i18n.isInitialized;
        console.log('[DIAG]', window.__DIAG.i18nStatus);
        clearInterval(checkI18n);
    }
}, 500);
setTimeout(function() { clearInterval(checkI18n); if (window.__DIAG.i18nStatus === 'initializing') window.__DIAG.i18nStatus = 'TIMEOUT - i18n not found'; }, 15000);
</script>
</head>
    <body class="{{ $css['body'] ?? 'bg-neutral-50' }}">

<div id="__diag_banner" style="position:fixed;top:0;left:0;right:0;z-index:99999;background:#1a1a2e;color:#e94560;padding:8px 16px;font-family:monospace;font-size:12px;border-bottom:2px solid #e94560;display:none;">
    <strong>DIAG:</strong> <span id="__diag_msg">Checking...</span>
    <button onclick="this.parentElement.style.display='none'" style="float:right;background:#333;color:#fff;border:none;padding:2px 8px;cursor:pointer;">X</button>
</div>
<script>
(function() {
    var banner = document.getElementById('__diag_banner');
    var msg = document.getElementById('__diag_msg');
    function showDiag(text, color) {
        banner.style.display = 'block';
        banner.style.color = color || '#e94560';
        msg.textContent = text;
    }
    function hideDiag() { banner.style.display = 'none'; }
    
    var i18nCheckCount = 0;
    var i18nCheck = setInterval(function() {
        i18nCheckCount++;
        if (typeof i18n !== 'undefined' && i18n) {
            var lang = i18n.language;
            var ready = i18n.isInitialized;
            if (lang === 'zh' && ready) {
                showDiag('OK: i18n language=' + lang + ' initialized=' + ready + ' | errors=' + window.__DIAG.errors.length + ' | Bundle: fa35f904', '#50fa7b');
                setTimeout(hideDiag, 5000);
            } else if (lang !== 'zh') {
                showDiag('WARN: i18n language is "' + lang + '" (expected "zh") | errors=' + window.__DIAG.errors.length, '#ffb86c');
            } else {
                showDiag('LOADING: language=' + lang + ' initialized=' + ready + ' | errors=' + window.__DIAG.errors.length, '#ffb86c');
            }
            clearInterval(i18nCheck);
        } else if (i18nCheckCount > 30) {
            showDiag('TIMEOUT: i18n not found after 15s. Errors: ' + JSON.stringify(window.__DIAG.errors.map(function(e){return e.msg})), '#e94560');
            clearInterval(i18nCheck);
        }
    }, 500);
    
    // Also check for JS errors
    var origErr = window.onerror;
    window.addEventListener('error', function(e) {
        showDiag('JS ERROR: ' + (e.message || 'unknown') + ' (see console)', '#e94560');
    });
})();
</script>
        @section('content')
            @yield('above-container')
            @yield('container')
            @yield('below-container')
        @show
        @include('partials.i18n-preload')
@section('scripts')
            {!! $asset->js('main.js') !!}
        @show
    </body>
</html>
