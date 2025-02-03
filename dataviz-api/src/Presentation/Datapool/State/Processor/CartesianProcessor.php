<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\State\Processor;

use ApiPlatform\Metadata\Operation;
use App\Application\Datapool\Command\Chart\MakeChartCommand;
use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSlug;
use App\Presentation\Datapool\Payload\Chart\Components\AxisDistributionPayload;
use App\Presentation\Datapool\Payload\Chart\Components\AxisOperationPayload;
use App\Presentation\Datapool\Payload\Chart\Components\FilterPayload;
use App\Presentation\Datapool\Payload\Chart\Components\SeriePayload;
use App\Presentation\Datapool\Payload\Chart\View\CartesianPayload;
use App\Presentation\Datapool\Resource\ChartResource;
use App\Shared\Domain\Exception\ViolationException;
use App\Shared\Presentation\AbstractProcessor;
use App\Shared\Presentation\ValidationException as PresentationValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

/**
 * @extends AbstractProcessor<CartesianPayload, ChartResource>
 */
class CartesianProcessor extends AbstractProcessor
{
    public function __construct(
        protected MessageBusInterface $bus,
        private LoggerInterface $logger,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): ?ChartResource {
        Assert::isInstanceOf($data, CartesianPayload::class);
        Assert::string($uriVariables['slug']);

        $command = new MakeChartCommand(
            slug: new DatasetSlug($uriVariables['slug']),
            axisOperation: null !== $data->operation ? AxisOperationPayload::toDomain($data->operation) : null,
            axisDistribution: null !== $data->distribution ? AxisDistributionPayload::toDomain($data->distribution) : null,
            serie: null !== $data->serie ? SeriePayload::toDomain($data->serie) : null,
            filters: null !== $data->filters ? FilterPayload::toArrayDomain($data->filters) : null,
            view: ViewEnum::CARTESIAN,
        );

        try {
            $model = $this->dispatch($command);

            return null !== $model ? ChartResource::fromDomain($model) : null;
        } catch (\Exception $exception) {
            $e = $exception->getPrevious();
            $this->logger->error($e->getMessage());

            if ($e instanceof ViolationException) {
                throw PresentationValidationException::toConstraintList($e->violations());
            }

            if ($e instanceof \InvalidArgumentException) {
                throw new NotFoundHttpException($e->getMessage());
            }

            throw $e;
        }
    }
}
