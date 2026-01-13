<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

final readonly class ContainerStats
{
    public function __construct(
        public string $name,
        public string $id,
        public \DateTimeImmutable $read,
        public \DateTimeImmutable $preread,
        public PidsStats $pidsStats,
        public BlkioStats $blkioStats,
        public int $numProcs,
        public ?StorageStats $storageStats,
        public CpuStats $cpuStats,
        public CpuStats $preCpuStats,
        public MemoryStats $memoryStats,
        /** @var array<string, NetworkStats> */
        public array $networks,
    ) {}
}
