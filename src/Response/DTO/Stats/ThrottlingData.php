<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

final readonly class ThrottlingData
{
    public function __construct(
        public int $periods,
        public int $throttledPeriods,
        public int $throttledTime,
    ) {}
}
