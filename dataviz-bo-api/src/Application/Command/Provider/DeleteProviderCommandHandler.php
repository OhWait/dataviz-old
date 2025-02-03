<?php

declare(strict_types=1);

namespace App\Application\Command\Provider;

use App\Domain\Repository\ProviderRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class DeleteProviderCommandHandler
{
    public function __construct(private ProviderRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteProviderCommand $command): void
    {
        $provider = $this->repository->find($command->slug->value);

        $this->repository->remove($provider);
    }
}
