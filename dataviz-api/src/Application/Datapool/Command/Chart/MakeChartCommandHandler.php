<?php

declare(strict_types=1);

namespace App\Application\Datapool\Command\Chart;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Datapool\Repository\ChartRepositoryInterface;
use App\Domain\Datapool\UseCase\Chart\RequestBuilder;
use App\Domain\Datapool\UseCase\Chart\RequestValidator;
use App\Domain\Dataviz\Model\Dataset;
use App\Domain\Dataviz\Repository\DatasetRepositoryInterface;
use App\Shared\Domain\Exception\ViolationException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class MakeChartCommandHandler
{
    private ?Dataset $dataset;
    private Request $request;

    public function __construct(
        private DatasetRepositoryInterface $datasetRepository,
        private ChartRepositoryInterface $chartRepository,
    ) {
    }

    public function __invoke(MakeChartCommand $command): ?Chart
    {
        return $this
            ->findDatasetWithMeta($command)
            ->buildRequest($command)
            ->validate()
            ->executeRequest($command->view);
    }

    private function findDatasetWithMeta(MakeChartCommand $command): self
    {
        if (null === $this->dataset = $this->datasetRepository->findWithMeta($command->slug->value)) {
            throw new \InvalidArgumentException();
        }

        if (null === $this->dataset->dataProvider()->value()) {
            throw new \InvalidArgumentException();
        }

        return $this;
    }

    // Autofill optionnals fields, make user life easier
    private function buildRequest(MakeChartCommand $command): self
    {
        $this->request = (new RequestBuilder($this->dataset))->build($command);

        return $this;
    }

    // Never trust client
    private function validate(): self
    {
        $validator = new RequestValidator($this->dataset);

        if ($validator->process($this->request)->isInvalid()) {
            throw new ViolationException($validator->violations());
        }

        return $this;
    }

    // Execute request and provide a Chart
    private function executeRequest(ViewEnum $view): ?Chart
    {
        return $this->chartRepository->getChart(
            $this->dataset,
            $view,
            $this->request,
        );
    }
}
