<?php
declare(strict_types=1);

namespace App\Service;

interface StorageInterface
{
    /** @param mixed $resource */
    public function setResource($resource);

    public function store($filename): string;

    public function generatePublicUrl($uri): string;
}