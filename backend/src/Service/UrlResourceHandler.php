<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Mime\MimeTypes;

class UrlResourceHandler implements ResourceHandlerInterface
{
    private StorageInterface $storage;


    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }


    public function process($resource): string
    {
        $content = file_get_contents($resource);
        $info = (new \finfo(FILEINFO_MIME_TYPE))->buffer($content);
        $mimeExtension = MimeTypes::getDefault()->getExtensions($info)[0] ?? null;
        $filename = pathinfo($resource, PATHINFO_BASENAME);
        $fileExtension = pathinfo($resource, PATHINFO_EXTENSION);

        if ($fileExtension !== $mimeExtension) {
            $filename .= '.' . $mimeExtension;
        }

        $this->storage->setResource($content);

        return $this->storage->store($filename);
    }
}
