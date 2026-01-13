<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

final readonly class PidsStats
{
    public function __construct(
        public int $current,
        public string $limit,
    ) {}
}
