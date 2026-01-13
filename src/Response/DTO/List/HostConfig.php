<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\List;

final readonly class HostConfig
{
    public function __construct(
        public ?string $NetworkMode,
        public ?array $Annotations
    ) {}
}
