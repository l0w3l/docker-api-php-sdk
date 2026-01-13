<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

final readonly class BlkioEntry
{
    public function __construct(
        public int $major,
        public int $minor,
        public string $op,
        public int $value,
    ) {}
}
