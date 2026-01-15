<?php

declare(strict_types=1);

namespace Lowel\Docker\Async;

use GuzzleHttp\Promise\PromiseInterface;
use Lowel\Docker\Exceptions\ContainerAlreadyStartedException;
use Lowel\Docker\Exceptions\ContainerAlreadyStoppedException;
use Lowel\Docker\Exceptions\ContainerNotFoundException;
use Lowel\Docker\Exceptions\DockerClientException;
use Lowel\Docker\Exceptions\DockerClientInvalidParamsException;
use Lowel\Docker\Exceptions\Response\ResponseErrorException;
use Lowel\Docker\Response\DTOFactory;
use Lowel\Docker\Response\ResponseParser;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class AsyncClientResponseHandler implements AsyncClientResponseHandlerInterface
{
    protected AsyncClientInterface $client;

    protected DTOFactory $dtoFactory;

    public function __construct(AsyncClientInterface $client)
    {
        $this->client = $client;

        $this->dtoFactory = new DTOFactory(new ResponseParser);
    }

    /**
     * {@inheritDoc}
     */
    public function containerList(bool $all = false, ?int $limit = null, bool $size = false, ?string $filters = null): PromiseInterface
    {
        return $this->client->containerList(...func_get_args())
            ->then(function (ResponseInterface $response) {
                return match ($response->getStatusCode()) {
                    Response::HTTP_BAD_REQUEST => throw new DockerClientInvalidParamsException(func_get_args(), $response),
                    Response::HTTP_OK => $this->dtoFactory->createDockerCollectionFromResponse($response),
                    default => throw new ResponseErrorException($response),
                };
            }, function (ClientExceptionInterface $clientException) {
                throw new DockerClientException(previous: $clientException);
            });
    }

    /**
     * {@inheritDoc}
     */
    public function containerInspect(string $id, bool $size = false): PromiseInterface
    {
        return $this->client->containerInspect(...func_get_args())
            ->then(function (ResponseInterface $response) use ($id) {
                return match ($response->getStatusCode()) {
                    Response::HTTP_NOT_FOUND => throw new ContainerNotFoundException($id),
                    Response::HTTP_OK => $this->dtoFactory->createContainerFromResponse($response),
                    default => throw new ResponseErrorException($response),
                };
            }, function (ClientExceptionInterface $clientException) {
                throw new DockerClientException(previous: $clientException);
            });
    }

    /**
     * {@inheritDoc}
     */
    public function containerStart(string $id, ?string $detachKeys = null): PromiseInterface
    {
        return $this->client->containerStart(...func_get_args())
            ->then(function (ResponseInterface $response) use ($id) {
                return match ($response->getStatusCode()) {
                    Response::HTTP_NOT_MODIFIED => throw new ContainerAlreadyStartedException($id),
                    Response::HTTP_NOT_FOUND => throw new ContainerNotFoundException($id),
                    Response::HTTP_NO_CONTENT => true,
                    default => throw new ResponseErrorException($response),
                };
            }, function (ClientExceptionInterface $clientException) {
                throw new DockerClientException(previous: $clientException);
            });
    }

    /**
     * {@inheritDoc}
     */
    public function containerStop(string $id, ?string $signal = null, ?int $t = null): PromiseInterface
    {
        return $this->client->containerStop(...func_get_args())
            ->then(function (ResponseInterface $response) use ($id) {
                return match ($response->getStatusCode()) {
                    Response::HTTP_NOT_MODIFIED => throw new ContainerAlreadyStoppedException($id),
                    Response::HTTP_NOT_FOUND => throw new ContainerNotFoundException($id),
                    Response::HTTP_NO_CONTENT => true,
                    default => throw new ResponseErrorException($response),
                };
            }, function (ClientExceptionInterface $clientException) {
                throw new DockerClientException(previous: $clientException);
            });
    }

    /**
     * {@inheritDoc}
     */
    public function containerRestart(string $id, ?string $signal = null, ?int $t = null): PromiseInterface
    {
        return $this->client->containerRestart(...func_get_args())
            ->then(function (ResponseInterface $response) use ($id) {
                return match ($response->getStatusCode()) {
                    Response::HTTP_NOT_FOUND => throw new ContainerNotFoundException($id),
                    Response::HTTP_NO_CONTENT => true,
                    default => throw new ResponseErrorException($response),
                };
            }, function (ClientExceptionInterface $clientException) {
                throw new DockerClientException(previous: $clientException);
            });
    }

    /**
     * {@inheritDoc}
     */
    public function containerStats(string $id, string $stream = 'false'): PromiseInterface
    {
        return $this->client->containerStats(...func_get_args())
            ->then(function (ResponseInterface $response) use ($id) {
                return match ($response->getStatusCode()) {
                    Response::HTTP_NOT_FOUND => throw new ContainerNotFoundException($id),
                    Response::HTTP_NO_CONTENT => $this->dtoFactory->createContainerStatsFromResponse($response),
                    default => throw new ResponseErrorException($response),
                };
            }, function (ClientExceptionInterface $clientException) {
                throw new DockerClientException(previous: $clientException);
            });
    }
}
