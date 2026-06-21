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

    public function __invoke(LocaleRequest $request): JsonResponse
    {
        $locale = $request->input('locale');
        $namespace = $request->input('namespace');

        // Debug: write to a log file directly
        $logMsg = date('Y-m-d H:i:s') . " | locale=$locale | ns=$namespace | ip=" . $request->ip() . PHP_EOL;
        file_put_contents('/app/storage/logs/locale-debug.log', $logMsg, FILE_APPEND);

        // PHP decodes "+" to space in query strings.
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