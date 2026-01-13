<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\List;

final readonly class IPAMConfig
{
    public function __construct(
        public ?string $IPv4Address,
        public ?string $IPv6Address,
        public ?array $LinkLocalIPs
    ) {}
}
