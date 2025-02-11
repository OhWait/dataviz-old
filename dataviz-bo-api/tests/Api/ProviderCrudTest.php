<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Provider;
use App\Tests\Data\Factory\ProviderFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ProviderCrudTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testCreateAMediaObject(): void
    {
        $provider = ProviderFactory::createOne();

        $sourcePath = __DIR__ . '/../Data/insee.png';
        $testPath = __DIR__ . '/../Data/insee_test.png';
        copy($sourcePath, $testPath);

        $file = new UploadedFile($testPath, 'insee.png', 'image/png', null, true);
        self::createClient()
            ->request(
                Request::METHOD_POST, 
                "/provider/{$provider->getSlug()}/upload-logo", 
                [
                    'headers' => ['Content-Type' => 'multipart/form-data'],
                    'extra' => [
                        'parameters' => [],
                        'files' => [
                            'file' => $file,
                        ],
                    ]
                ]
            );

        $this->assertResponseIsSuccessful();
        $this->assertMatchesResourceItemJsonSchema(Provider::class);
        $this->assertJsonContains([
            // 'title' => 'My file uploaded',
        ]);
    }
}