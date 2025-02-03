<?php

declare(strict_types=1);

namespace App\Presentation\State\Processor\Theme;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\ParameterValidator\Exception\ValidationException;
use App\Application\Command\Theme\UpdateThemeCommand;
use App\Domain\Model\Theme;
use App\Domain\ValueObject\Theme\ThemeSlug;
use App\Domain\ValueObject\Theme\ThemeTitle;
use App\Presentation\Resource\ThemeResource;
use App\Shared\Presentation\AbstractProcessor;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends AbstractProcessor<ThemeResource, ThemeResource>
 */
final class ThemeUpdateProcessor extends AbstractProcessor
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
    ): ThemeResource {
        try {
            $model = $this->updateCommand($data);

            return ThemeResource::fromDomain($model);
        } catch (\Exception $e) {
            throw new ValidationException([], $e->getPrevious()->getMessage());
        }
    }

    private function updateCommand(ThemeResource $data): Theme
    {
        $message = new UpdateThemeCommand(
            slug: new ThemeSlug($data->slug),
            title: new ThemeTitle($data->title),
        );

        return $this->dispatch($message);
    }
}
