<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\List;

final readonly class Port
{
    public function __construct(
        public int $PrivatePort,
        public ?int $PublicPort,
        public string $Type
    ) {}
}
