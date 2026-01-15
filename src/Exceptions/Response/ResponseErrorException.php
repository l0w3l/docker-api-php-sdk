<?php

declare(strict_types=1);

namespace Lowel\Docker\Exceptions\Response;

use GuzzleHttp\Psr7\Response;
use RuntimeException;

use function print_r;
use function sprintf;

class ResponseErrorException extends RuntimeException
{
    public function __construct(Response $errorResponse)
    {
        parent::__construct($errorResponse->getBody()->getContents(), $errorResponse->getStatusCode());
    }

    /**
     * Convert given array into string
     */
    public function printAsString(mixed $value): string
    {
        return print_r($value, true);
    }

    /**
     * Formatted print
     */
    public function format(string $message, string ...$params): string
    {
        return sprintf($message, ...$params);
    }
}
