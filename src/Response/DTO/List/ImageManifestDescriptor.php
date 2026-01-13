<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\List;

final readonly class ImageManifestDescriptor
{
    public function __construct(
        public string $mediaType,
        public string $digest,
        public int $size,
        public array $urls,
        public array $annotations,
        public ?string $data,
        public Platform $platform,
        public ?string $artifactType
    ) {}
}
