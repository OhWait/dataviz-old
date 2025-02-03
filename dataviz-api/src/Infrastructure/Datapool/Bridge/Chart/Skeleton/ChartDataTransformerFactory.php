<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Bridge\Chart\Skeleton;

use App\Domain\Datapool\Enum\Chart\ViewEnum;

class ChartDataTransformerFactory
{
    /**
     * @param ChartDataTransformerInterface[] $dataTransformers
     */
    public function __construct(private iterable $dataTransformers)
    {
    }

    public function getDataTransformer(ViewEnum $view): ChartDataTransformerInterface
    {
        foreach ($this->dataTransformers as $dataTransformer) {
            if ($dataTransformer->supports($view)) {
                return $dataTransformer;
            }
        }

        throw new \Exception();
    }
}
