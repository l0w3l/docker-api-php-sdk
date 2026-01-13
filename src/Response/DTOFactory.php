<?php

declare(strict_types=1);

namespace Lowel\Docker\Response;

use Lowel\Docker\Response\DTO\Inspect\Container;
use Lowel\Docker\Response\DTO\Inspect\ContainerFactory;
use Lowel\Docker\Response\DTO\List\ContainerListFactory;
use Lowel\Docker\Response\DTO\List\ContainerListItem;
use Lowel\Docker\Response\DTO\Stats\ContainerStats;
use Lowel\Docker\Response\DTO\Stats\ContainerStatsFactory;
use Psr\Http\Message\ResponseInterface;

class DTOFactory
{
    protected ResponseParserInterface $responseParser;

    public function __construct(ResponseParserInterface $responseParser)
    {
        $this->responseParser = $responseParser;
    }

    /**
     * @return array<ContainerListItem>
     */
    public function createDockerCollectionFromResponse(ResponseInterface $response): array
    {
        $collection = [];
        $arrayData = $this->responseParser->parseBodyAsJson($response);

        foreach ($arrayData as $containerInfo) {
            $collection[] = ContainerListFactory::fromArray($containerInfo);
        }

        return $collection;
    }

    public function createContainerFromResponse(ResponseInterface $response): Container
    {
        $arrayData = $this->responseParser->parseBodyAsJson($response);

        return ContainerFactory::fromArray($arrayData);
    }

    public function createContainerStatsFromResponse(ResponseInterface $response): ContainerStats
    {
        $arrayData = $this->responseParser->parseBodyAsJson($response);

        return ContainerStatsFactory::fromArray($arrayData);
    }
}
