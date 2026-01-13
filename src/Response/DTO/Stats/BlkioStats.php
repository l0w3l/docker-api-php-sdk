<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

final readonly class BlkioStats
{
    /**
     * @param  BlkioEntry[]|null  $ioServiceBytesRecursive
     */
    public function __construct(
        public ?array $ioServiceBytesRecursive,
        public ?array $ioServicedRecursive,
        public ?array $ioQueueRecursive,
        public ?array $ioServiceTimeRecursive,
        public ?array $ioWaitTimeRecursive,
        public ?array $ioMergedRecursive,
        public ?array $ioTimeRecursive,
        public ?array $sectorsRecursive,
    ) {}
}
