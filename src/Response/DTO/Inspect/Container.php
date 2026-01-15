<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Inspect;

final readonly class Container
{
    /**
     * @param  string[]  $Args
     * @param  string[]  $ExecIDs
     */
    public function __construct(
        public string $Id,
        public string $Created,
        public string $Path,
        public array $Args,
        public State $State,
        public string $Image,
        public string $ResolvConfPath,
        public string $HostnamePath,
        public string $HostsPath,
        public string $LogPath,
        public string $Name,
        public int $RestartCount,
        public string $Driver,
        public string $Platform,
        public ?ImageManifestDescriptor $ImageManifestDescriptor,
        public string $MountLabel,
        public string $ProcessLabel,
        public string $AppArmorProfile,
        public array $ExecIDs,
        public ?GraphDriver $GraphDriver,
        public ?string $SizeRw,
        public ?string $SizeRootFs
    ) {}
}
