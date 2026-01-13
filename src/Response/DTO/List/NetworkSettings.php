<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\List;

final readonly class NetworkSettings
{
    public function __construct(
        /** @var NetworkProperty[] */
        public array $Networks
    ) {}
}
