<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileResourceHandler implements ResourceHandlerInterface
{
    private SluggerInterface $slugger;
    private StorageInterface $storage;


    public function __construct(StorageInterface $storage, SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
        $this->storage = $storage;
    }


    /**
     * @param UploadedFile $resource
     *
     * @return string
     */
    public function process($resource): string
    {
        $originalFilename = pathinfo($resource->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $resource->guessExtension();

        $this->storage->setResource($resource);

        return $this->storage->store($fileName);
    }
}
