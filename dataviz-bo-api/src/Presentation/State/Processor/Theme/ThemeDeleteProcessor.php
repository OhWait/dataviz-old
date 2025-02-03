<?php

declare(strict_types=1);

namespace App\Presentation\State\Processor\Theme;

use ApiPlatform\Metadata\Operation;
use App\Application\Command\Theme\DeleteThemeCommand;
use App\Domain\ValueObject\Theme\ThemeSlug;
use App\Presentation\Resource\ThemeResource;
use App\Shared\Presentation\AbstractProcessor;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends AbstractProcessor<ThemeResource, void>
 */
final class ThemeDeleteProcessor extends AbstractProcessor
{
    public function __construct(
        protected MessageBusInterface $bus,
    ) {
    }

    /**
     * @param ThemeResource $data
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): void {
        $message = new DeleteThemeCommand(
            new ThemeSlug($data->slug),
        );

        $this->dispatch($message);
    }
}
