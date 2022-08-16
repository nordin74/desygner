<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class StorageFactory
{
    public array $storages = [];

    public function __construct(ContainerInterface $container)
    {
        $this->storages = [
            'file' => fn() => $container->get('App\\Service\\FSStorage'),
            'dht' => null,
            'aws' => null,
        ];
    }


    public function createFromUri($uri): StorageInterface
    {
        $schema = parse_url($uri, PHP_URL_SCHEME);

        return $this->storages[$schema]();
    }
}