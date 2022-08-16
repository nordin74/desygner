<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FSStorage implements StorageInterface
{
    const MODE_UPLOADED_FILE = 1;
    const MODE_CONTENT       = 2;
    private string       $storeDirectory;
    private int          $mode;
    /** @var string | UploadedFile */
    private        $resource;
    private string $baseUrl;


    public function __construct($storeDirectory)
    {
        $this->storeDirectory = $storeDirectory;
        $this->baseUrl = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on' ? 'https' : 'http') .
            "://{$_SERVER['HTTP_HOST']}";
    }


    public function setResource($resource)
    {
        if ($resource instanceof UploadedFile) {
            $this->mode = self::MODE_UPLOADED_FILE;
        } else {
            $this->mode = self::MODE_CONTENT;
        }

        $this->resource = $resource;
    }


    public function store($filename): string
    {
        if ($this->mode === self::MODE_UPLOADED_FILE) {
            $this->resource->move($this->storeDirectory, $filename);
        } else {
            file_put_contents($this->storeDirectory . '/' . $filename, $this->resource);
        }


        return 'file://' . $this->storeDirectory . '/' . $filename;
    }


    public function generatePublicUrl($uri): string
    {
        return $this->baseUrl . '/' . basename($this->storeDirectory) . '/' . basename($uri);
    }
}