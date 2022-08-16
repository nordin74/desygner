<?php
declare(strict_types=1);

namespace App\Service;

interface ResourceHandlerInterface
{
    public function process($resource);

//    public function canProcess($resource);
}