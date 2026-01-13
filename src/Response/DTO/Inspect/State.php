<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Inspect;

final readonly class State
{
    public function __construct(
        public string $Status,
        public bool $Running,
        public bool $Paused,
        public bool $Restarting,
        public bool $OOMKilled,
        public bool $Dead,
        public int $Pid,
        public int $ExitCode,
        public string $Error,
        public string $StartedAt,
        public string $FinishedAt,
        public ?Health $Health
    ) {}
}
