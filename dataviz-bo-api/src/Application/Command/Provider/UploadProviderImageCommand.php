<?php

declare(strict_types=1);

namespace App\Application\Command\Provider;

use App\Domain\ValueObject\Provider\ProviderSlug;
use Symfony\Component\HttpFoundation\File\File;

final readonly class UploadProviderImageCommand
{
  public function __construct(
    public ProviderSlug $slug,
    public File $file,
  ) {
  }
}