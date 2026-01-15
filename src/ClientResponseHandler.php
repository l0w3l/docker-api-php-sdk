<?php

declare(strict_types=1);

namespace Lowel\Docker;

use Lowel\Docker\Exceptions\ContainerAlreadyStartedException;
use Lowel\Docker\Exceptions\ContainerAlreadyStoppedException;
use Lowel\Docker\Exceptions\ContainerNotFoundException;
use Lowel\Docker\Exceptions\DockerClientException;
use Lowel\Docker\Exceptions\DockerClientInvalidParamsException;
use Lowel\Docker\Exceptions\Response\ResponseErrorException;
use Lowel\Docker\Response\DTO\Inspect\Container;
use Lowel\Docker\Response\DTO\Stats\ContainerStats;
use Lowel\Docker\Response\DTOFactory;
use Lowel\Docker\Response\ResponseParser;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

use function func_get_args;

class ClientResponseHandler implements ClientResponseHandlerInterface
{
    protected ClientInterface $client;

    protected DTOFactory $dtoFactory;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;

        $this->dtoFactory = new DTOFactory(new ResponseParser);
    }

    /**
     * {@inheritDoc}
     */
    public function containerList(bool $all = false, ?int $limit = null, bool $size = false, ?string $filters = null): array
    {
        try {
            $response = $this->client->containerList(...func_get_args());
        } catch (ClientExceptionInterface $clientException) {
            throw new DockerClientException(previous: $clientException);
        }

        return match ($response->getStatusCode()) {
            Response::HTTP_BAD_REQUEST => throw new DockerClientInvalidParamsException(func_get_args(), $response),
            Response::HTTP_INTERNAL_SERVER_ERROR => throw new DockerClientException,
            Response::HTTP_OK => $this->dtoFactory->createDockerCollectionFromResponse($response)
        };
    }

    /**
     * {@inheritDoc}
     */
    public function containerInspect(string $id, bool $size = false): Container
    {
        try {
            $response = $this->client->containerInspect(...func_get_args());
        } catch (ClientExceptionInterface $clientException) {
            throw new DockerClientException(previous: $clientException);
        }

        return match ($response->getStatusCode()) {
            Response::HTTP_NOT_FOUND => throw new ContainerNotFoundException($id),
            Response::HTTP_OK => $this->dtoFactory->createContainerFromResponse($response),
            default => throw new ResponseErrorException($response),
        };
    }

    /**
     * {@inheritDoc}
     */
    public function containerStart(string $id, ?string $detachKeys = null): bool
    {
        try {
            $response = $this->client->containerStart(...func_get_args());
        } catch (ClientExceptionInterface $clientException) {
            throw new DockerClientException(previous: $clientException);
        }

        return match ($response->getStatusCode()) {
            Response::HTTP_NOT_MODIFIED => throw new ContainerAlreadyStartedException($id),
            Response::HTTP_NOT_FOUND => throw new ContainerNotFoundException($id),
            Response::HTTP_NO_CONTENT => true,
            default => throw new ResponseErrorException($response),
        };
    }

    /**
     * {@inheritDoc}
     */
    public function containerStop(string $id, ?string $signal = null, ?int $t = null): bool
    {
        try {
            $response = $this->client->containerStop(...func_get_args());
        } catch (ClientExceptionInterface $clientException) {
            throw new DockerClientException(previous: $clientException);
        }

        return match ($response->getStatusCode()) {
            Response::HTTP_NOT_MODIFIED => throw new ContainerAlreadyStoppedException($id),
            Response::HTTP_NOT_FOUND => throw new ContainerNotFoundException($id),
            Response::HTTP_NO_CONTENT => true,
            default => throw new ResponseErrorException($response),
        };
    }

    /**
     * {@inheritDoc}
     */
    public function containerRestart(string $id, ?string $signal = null, ?int $t = null): bool
    {
        try {
            $response = $this->client->containerRestart(...func_get_args());
        } catch (ClientExceptionInterface $clientException) {
            throw new DockerClientException(previous: $clientException);
        }

        return match ($response->getStatusCode()) {
            Response::HTTP_NOT_FOUND => throw new ContainerNotFoundException($id),
            Response::HTTP_NO_CONTENT => true,
            default => throw new ResponseErrorException($response),
        };
    }

    public function containerStats(string $id, string $stream = 'false'): ContainerStats
    {
        try {
            $response = $this->client->containerStats(...func_get_args());
        } catch (ClientExceptionInterface $clientException) {
            throw new DockerClientException(previous: $clientException);
        }

        return match ($response->getStatusCode()) {
            Response::HTTP_NOT_FOUND => throw new ContainerNotFoundException($id),
            Response::HTTP_OK => $this->dtoFactory->createContainerStatsFromResponse($response),
            default => throw new ResponseErrorException($response),
        };
    }
}
