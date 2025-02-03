<?php

declare(strict_types=1);

namespace App\Presentation\State\Processor\Provider;

use ApiPlatform\Exception\InvalidArgumentException;
use ApiPlatform\Metadata\Operation;
use App\Application\Command\Provider\UploadProviderImageCommand;
use App\Domain\ValueObject\Provider\ProviderSlug;
use App\Presentation\Resource\ProviderResource;
use App\Shared\Presentation\AbstractProcessor;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends AbstractProcessor<ProviderResource, ProviderResource>
 */
final class ProviderUploadImageProcessor extends AbstractProcessor
{
    public function __construct(
        protected MessageBusInterface $bus,
        private RequestStack $requestStack
    ) {
    }

    /**
     * @param ProviderResource $data
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): ProviderResource {
        $file = $this->requestStack->getCurrentRequest()->files->get('file');

        if (!$file instanceof UploadedFile) {
            throw new InvalidArgumentException('File is missing.');
        }

        try {
            return $this->sendMessage($uriVariables['slug'], $file);
        } catch (\Exception $e) {
            if ($e->getPrevious()?->getCode() === Response::HTTP_NOT_FOUND) {
                throw new NotFoundHttpException($e->getPrevious()->getMessage());
            }
            throw $e;
        }
    }
    
    private function sendMessage(string $slug, File $file): ProviderResource
    {
        $command = new UploadProviderImageCommand(
            slug: new ProviderSlug($slug),
            file: $file
        );
        
        $model = $this->dispatch($command);

        return ProviderResource::fromDomain($model);
    }
}
