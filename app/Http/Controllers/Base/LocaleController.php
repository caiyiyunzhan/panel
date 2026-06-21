<?php

namespace Pterodactyl\Http\Controllers\Base;

use Illuminate\Http\JsonResponse;
use Illuminate\Translation\Translator;
use Illuminate\Contracts\Translation\Loader;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Http\Requests\Base\LocaleRequest;

class LocaleController extends Controller
{
    protected Loader $loader;

    public function __construct(Translator $translator)
    {
        $this->loader = $translator->getLoader();
    }

    /**
     * Returns translation data given a specific locale and namespace.
     * Supports multi-namespace loading with "+" separator (e.g., "auth+strings").
     * Also handles spaces (PHP converts + to space in query strings).
     */
    public function __invoke(LocaleRequest $request): JsonResponse
    {
        $locale = $request->input('locale');
        $namespace = $request->input('namespace');

        // PHP decodes "+" to space in query strings.
        // Convert spaces back to "+" then split, supporting both formats.
        $namespace = str_replace(' ', '+', $namespace);
        $namespaces = explode('+', $namespace);
        $response = [];

        foreach ($namespaces as $ns) {
            if ($ns === '') continue;
            try {
                $response[$locale][$ns] = $this->i18n($this->loader->load($locale, $ns));
            } catch (\Exception $e) {
                $response[$locale][$ns] = new \stdClass();
            }
        }

        return new JsonResponse($response, 200, [
            'Cache-Control' => 'public, max-age=3600, stale-while-revalidate=86400',
            'ETag' => md5(json_encode($response, JSON_THROW_ON_ERROR)),
        ]);
    }

    /**
     * Convert standard Laravel translation keys that look like ":foo"
     * into key structures that are supported by the front-end i18n
     * library, like "{{foo}}".
     */
    protected function i18n(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->i18n($value);
            } else {
                $data[$key] = preg_replace('/:([\w.-]+\w)([^\w:]?|$)/m', '{{$1}}$2', $value);
            }
        }

        return $data;
    }
}