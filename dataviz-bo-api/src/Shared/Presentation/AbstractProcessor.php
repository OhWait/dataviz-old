<?php

declare(strict_types=1);

namespace App\Shared\Presentation;

use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * @template T1
 * @template T2
 *
 * @implements ProcessorInterface<T1, T2>
 */
abstract class AbstractProcessor implements ProcessorInterface
{
    protected MessageBusInterface $bus;

    protected function dispatch(mixed $message): mixed
    {
        return $this->bus
            ->dispatch($message)
            ->last(HandledStamp::class)
            ->getResult();
    }
}
