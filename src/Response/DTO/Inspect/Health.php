<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Inspect;

final readonly class Health
{
    /**
     * @var LogEntry[]
     */
    public function __construct(
        public string $Status,
        public int $FailingStreak,
        public array $Log
    ) {}
}
