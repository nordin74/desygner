<?php
declare(strict_types=1);

namespace App\Serializer;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProblemJsonNormalizer implements NormalizerInterface
{
    public function normalize($exception, string $format = null, array $context = [])
    {
        $debug = ($context['debug'] ?? true);

        $data = [
            'title' => $exception->getStatusText(),
            'status' => $exception->getStatusCode(),
            'detail' => $exception->getStatusCode() >= 500 && !$debug ? 'Unknown error' :
                $exception->getMessage()
        ];

        if ($debug) {
            $data['class'] = $exception->getClass();
            $data['trace'] = $exception->getTrace();
        }

        return $data;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return 'json' === $format && $data instanceof FlattenException;
    }
}