{{--
    Preload all Chinese translations as embedded JSON.
    This bypasses the async i18next HTTP backend, ensuring
    translations are available before React renders.
--}}
@php
try {
    $loader = app('translator')->getLoader();
    $locales = ['zh'];
    $namespaces = ['auth', 'strings', 'admin', 'server', 'dashboard', 'pagination', 'passwords', 'validation', 'activity', 'exceptions'];
    $preload = [];
    foreach ($locales as $locale) {
        foreach ($namespaces as $ns) {
            try {
                $data = $loader->load($locale, $ns);
                // Convert Laravel :param to i18next {{param}}
                array_walk_recursive($data, function (&$v) {
                    if (is_string($v)) {
                        $v = preg_replace('/:([\w.-]+\w)([^\w:]?|$)/m', '{{$1}}$2', $v);
                    }
                });
                $preload[$locale][$ns] = $data;
            } catch (\Exception $e) {
                // namespace not found for this locale - skip
            }
        }
    }
} catch (\Exception $e) {
    $preload = [];
}
@endphp
<script>
window.__PRELOADED_TRANSLATIONS = {!! json_encode($preload, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
console.log('[PRELOAD] Embedded translations for:', Object.keys(window.__PRELOADED_TRANSLATIONS.zh || {}));
</script>