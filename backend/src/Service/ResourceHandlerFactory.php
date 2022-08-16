<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

final class ResourceHandlerFactory
{
    private ContainerInterface $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /** @noinspection PhpIncompatibleReturnTypeInspection */
    public function create(string $class): ResourceHandlerInterface
    {
        switch ($class) {
            case 'file':
                return $this->container->get('App\\Service\\FileResourceHandler');
            case 'url':
                return $this->container->get('App\\Service\\UrlResourceHandler');
        }

        throw new \InvalidArgumentException('Unknown resource given');
    }
}