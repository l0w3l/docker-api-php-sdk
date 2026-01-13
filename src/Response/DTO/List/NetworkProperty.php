<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\List;

final readonly class NetworkProperty
{
    public function __construct(
        public IPAMConfig $IPAMConfig,
        public ?array $Links,
        public string $MacAddress,
        public ?array $Aliases,
        public ?array $DriverOpts,
        public null|int|array $GwPriority,
        public string $NetworkID,
        public string $EndpointID,
        public string $Gateway,
        public string $IPAddress,
        public int $IPPrefixLen,
        public string $IPv6Gateway,
        public string $GlobalIPv6Address,
        public int $GlobalIPv6PrefixLen,
        public ?array $DNSNames
    ) {}
}
