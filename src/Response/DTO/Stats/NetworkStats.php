<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

final readonly class NetworkStats
{
    public function __construct(
        public int $rxBytes,
        public int $rxDropped,
        public int $rxErrors,
        public int $rxPackets,
        public int $txBytes,
        public int $txDropped,
        public int $txErrors,
        public int $txPackets,
    ) {}
}
