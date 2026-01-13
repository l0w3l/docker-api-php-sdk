<?php

declare(strict_types=1);

namespace Lowel\Docker\Requests;

use JsonException;
use Lowel\Docker\Exceptions\Requests\UriParamWasNotFounded;

use function http_build_query;
use function preg_match_all;
use function str_replace;

class RequestBuilder
{
    public function __construct(
        public readonly string $method = '',
        public readonly string $uri = '',
        public readonly array $headers = [],
        public readonly string $body = '',
        public readonly string $version = '1.1'
    ) {}

    private function clone(
        self $cloneable,
        ?string $method = null,
        ?string $uri = null,
        ?array $headers = null,
        ?string $body = null,
        ?string $version = null
    ): self {
        return new self(
            $method ?? $cloneable->method,
            $uri ?? $cloneable->uri,
            $headers ?? $cloneable->headers,
            $body ?? $cloneable->body,
            $version ?? $cloneable->version
        );
    }

    public function setMethod(string $method): self
    {
        return $this->clone($this, method: $method);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public function setUriQueryParams(array $params): self
    {
        return $this->setUri("{$this->uri}?".http_build_query($params));
    }

    /**
     * Set uri with given params
     */
    public function setUri(string $uri, array $params = []): self
    {
        return $this->clone($this, uri: $this->uriFormatter($uri, $params));
    }

    public function setHeaders(array $headers): self
    {
        return $this->clone($this, headers: $headers);
    }

    /**
     * @throws JsonException
     */
    public function setBodyJson(array $body): self
    {
        $body = array_filter($body, fn ($x) => $x !== null);

        $json = json_encode($body);

        if ($json === false) {
            throw new JsonException(print_r($body, true));
        }

        return $this
            ->setHeaders(['Content-Type' => 'application/json'])
            ->setBody($json);
    }

    public function setBodyWithQueryParams(array $body): self
    {
        $queryParams = http_build_query($body);

        return $this
            ->setHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
            ->setBody($queryParams);
    }

    public function setBody(string $body): self
    {
        return $this->clone($this, body: $body);
    }

    public function setVersion(string $version): self
    {
        return $this->clone($this, version: $version);
    }

    public function uriFormatter(string $uri, array $params): string
    {
        preg_match_all('/{([^{}]+)}/', $uri, $matches);

        foreach ($matches[1] as $paramName) {
            $paramValue = $params[$paramName]
                ?? throw new UriParamWasNotFounded($uri, $paramName, $params);

            $uri = str_replace("{{$paramName}}", (string) $paramValue, $uri);
        }

        return $uri;
    }
}
