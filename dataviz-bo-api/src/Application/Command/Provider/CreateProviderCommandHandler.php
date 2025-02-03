<?php

declare(strict_types=1);

namespace App\Application\Command\Provider;

use App\Domain\Model\Provider;
use App\Domain\Repository\ProviderRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class CreateProviderCommandHandler
{
    public function __construct(
        private readonly ProviderRepositoryInterface $repository,
    ) {
    }

    public function __invoke(CreateProviderCommand $command): Provider
    {
        $provider = new Provider(
            slug: $command->slug,
            name: $command->name,
            acronym: $command->acronym,
            description: $command->description,
        );

        $this->repository->save($provider);

        return $this->repository->find($command->slug);
    }
}
