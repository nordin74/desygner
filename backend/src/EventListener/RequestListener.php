<?php
declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

final class RequestListener
{
    private bool $forceRequestAsJson;


    public function __construct(bool $forceRequestAsJson)
    {
        $this->forceRequestAsJson = $forceRequestAsJson;
    }


    public function onKernelRequest(RequestEvent $event, $a, $b)
    {
        if (!$this->forceRequestAsJson) {
            return;
        }

        $event->getRequest()->setRequestFormat('json');
    }
}