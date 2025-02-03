<?php

declare(strict_types=1);

namespace App\Application\Command\Provider;

use App\Domain\Model\Provider;
use App\Domain\Repository\ProviderRepositoryInterface;
use App\Domain\ValueObject\Provider\ProviderSlug;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Vich\UploaderBundle\Handler\UploadHandler;

#[AsMessageHandler()]
final class UploadProviderImageCommandHandler
{
    public const IMAGE_UPLOAD_DIRECTORY = '/var/shared_data/';

    private ?Provider $provider = null;

    public function __construct(
        private readonly ProviderRepositoryInterface $repository,
        private readonly UploadHandler $uploadHandler,
    ) {
    }

    public function __invoke(UploadProviderImageCommand $command): Provider
    {
        return $this
            ->findProvider($command->slug)
            ->removeOldImage()
            ->uploadImage($command->file)
            ->provider;
    }

    private function findProvider(ProviderSlug $slug): self
    {
        if (null === $this->provider = $this->repository->find($slug)) {
            throw new \InvalidArgumentException(
                sprintf('Provider not found.', $slug),
                404
            );
        }

        return $this;
    }

    private function removeOldImage(): self
    {
        if ($this->provider->image()->isEmpty()) {
            return $this;
        }

        $filePath = self::IMAGE_UPLOAD_DIRECTORY . $this->provider->image()->value;

        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }

        return $this;
    }

    private function uploadImage(File $file): self
    {
        $this->provider->setImageFile($file);
        $this->uploadHandler->upload($this->provider, 'imageFile');
        $this->repository->save($this->provider);

        return $this;
    }
}
