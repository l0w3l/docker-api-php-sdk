<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\List;

final readonly class Platform
{
    public function __construct(
        public string $architecture,
        public string $os,
        public string $osVersion,
        public array $osFeatures,
        public ?string $variant
    ) {}
}
