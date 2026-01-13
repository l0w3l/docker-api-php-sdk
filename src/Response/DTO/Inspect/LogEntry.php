<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Inspect;

final readonly class LogEntry
{
    public function __construct(
        public string $Start,
        public string $End,
        public int $ExitCode,
        public string $Output
    ) {}
}
