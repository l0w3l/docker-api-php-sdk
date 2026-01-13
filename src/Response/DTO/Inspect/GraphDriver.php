<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Inspect;

final readonly class GraphDriver
{
    public function __construct(
        public string $Name,
        public GraphDriverData $Data
    ) {}
}
