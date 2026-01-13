<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

final readonly class StorageStats
{
    public function __construct(
        public int $readCountNormalized,
        public int $readSizeBytes,
        public int $writeCountNormalized,
        public int $writeSizeBytes,
    ) {}
}
