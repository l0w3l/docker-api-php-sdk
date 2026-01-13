<?php

declare(strict_types=1);

namespace Lowel\Docker\Exceptions;

use RuntimeException;
use Throwable;

use function print_r;
use function sprintf;

class DockerClientException extends RuntimeException
{
    const DEFAULT_MESSAGE = 'Docker error';

    public function __construct(string $message = self::DEFAULT_MESSAGE, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
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
