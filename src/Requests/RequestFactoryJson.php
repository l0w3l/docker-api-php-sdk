<?php

declare(strict_types=1);

namespace Lowel\Docker\Requests;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class RequestFactoryJson implements RequestFactoryInterface
{
    protected RequestBuilder $requestBuilder;

    public function __construct()
    {
        $this->requestBuilder = new RequestBuilder;
    }

    /**
     * @param  array  $data
     *
     * @throws \JsonException
     */
    public function get(RequestTypeEnum $requestTypeEnum, array $params, $data): RequestInterface
    {
        return $this->requestFromRequestBuilder(
            $this->requestBuilder
                ->setMethod('GET')
                ->setUri($requestTypeEnum->value, $params)
                ->setUriQueryParams($data)
        );
    }

    /**
     * @param  array  $data
     *
     * @throws \JsonException
     */
    public function post(RequestTypeEnum $requestTypeEnum, array $params, $data): RequestInterface
    {
        return $this->requestFromRequestBuilder(
            $this->requestBuilder
                ->setMethod('POST')
                ->setUri($requestTypeEnum->value, $params)
                ->setBodyJson($data)
        );
    }

    protected function requestFromRequestBuilder(RequestBuilder $requestBuilder): RequestInterface
    {
        $request = new Request(
            $requestBuilder->method,
            $requestBuilder->uri,
            $requestBuilder->headers,
            $requestBuilder->body,
            $requestBuilder->version
        );

        return $request;
    }
}
