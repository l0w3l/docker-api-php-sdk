<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

final readonly class CpuStats
{
    public function __construct(
        public CpuUsage $cpuUsage,
        public int $systemCpuUsage,
        public int $onlineCpus,
        public ThrottlingData $throttlingData,
    ) {}
}
