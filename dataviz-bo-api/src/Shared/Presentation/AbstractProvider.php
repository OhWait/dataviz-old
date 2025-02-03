<?php

declare(strict_types=1);

namespace App\Shared\Presentation;

use ApiPlatform\State\Pagination\PartialPaginatorInterface;
use ApiPlatform\State\ProviderInterface;
use App\Shared\Domain\Repository\PaginatorInterface;
use App\Shared\Infrastructure\ApiPlatform\Paginator;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * @template T of object
 *
 * @implements ProviderInterface<T>
 */
abstract class AbstractProvider implements ProviderInterface
{
    protected MessageBusInterface $bus;

    protected function dispatch(mixed $message): mixed
    {
        return $this->bus
            ->dispatch($message)
            ->last(HandledStamp::class)
            ->getResult();
    }

    protected function paginate(
        string $class,
        string $method,
        PaginatorInterface $paginator,
    ): PartialPaginatorInterface {
        return new Paginator(
            new \ArrayObject(
                call_user_func(
                    [$class, $method],
                    \iterator_to_array($paginator->getIterator()),
                ),
            ),
            $paginator->getCurrentPage(),
            $paginator->getItemsPerPage(),
            $paginator->getTotalItems(),
        );
    }
}
