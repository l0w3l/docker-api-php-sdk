<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Inspect;

final readonly class GraphDriverData
{
    public function __construct(
        public string $MergedDir,
        public string $UpperDir,
        public string $WorkDir
    ) {}
}
