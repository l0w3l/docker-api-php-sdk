<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

final readonly class MemoryStats
{
    public function __construct(
        public int $usage,
        public ?int $maxUsage,
        public MemoryDetailedStats $stats,
        public ?int $failcnt,
        public int $limit,
        public ?int $commitbytes,
        public ?int $commitpeakbytes,
        public ?int $privateworkingset,
    ) {}
}
