<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\List;

final readonly class Mount
{
    public function __construct(
        public string $Type,
        public ?string $Name,
        public string $Source,
        public string $Destination,
        public ?string $Driver,
        public string $Mode,
        public bool $RW,
        public string $Propagation
    ) {}
}
