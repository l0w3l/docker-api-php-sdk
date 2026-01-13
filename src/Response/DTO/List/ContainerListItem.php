<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\List;

final readonly class ContainerListItem
{
    public function __construct(
        public string $Id,
        public array $Names,
        public string $Image,
        public string $ImageID,
        public ?ImageManifestDescriptor $ImageManifestDescriptor,
        public string $Command,
        public \DateTimeImmutable $Created,
        /** @var Port[] */
        public array $Ports,
        public ?string $SizeRw,
        public ?string $SizeRootFs,
        public array $Labels,
        public string $State,
        public string $Status,
        public HostConfig $HostConfig,
        public NetworkSettings $NetworkSettings,
        /** @var Mount[] */
        public array $Mounts
    ) {}
}
