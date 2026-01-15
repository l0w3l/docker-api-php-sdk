<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Inspect;

final readonly class Platform
{
    /**
     * @var string[]
     */
    public function __construct(
        public ?string $architecture,
        public ?string $os,
        public ?string $os_version,
        public ?array $os_features,
        public ?string $variant
    ) {}
}
