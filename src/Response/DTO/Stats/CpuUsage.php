<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

final readonly class CpuUsage
{
    /**
     * @param  int[]  $percpuUsage
     */
    public function __construct(
        public int $totalUsage,
        public array $percpuUsage,
        public int $usageInKernelmode,
        public int $usageInUsermode,
    ) {}
}
