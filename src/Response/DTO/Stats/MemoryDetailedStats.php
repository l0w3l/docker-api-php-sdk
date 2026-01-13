<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

final readonly class MemoryDetailedStats
{
    public function __construct(
        public int $activeAnon,
        public int $activeFile,
        public int $anon,
        public int $anonThp,
        public int $file,
        public int $fileDirty,
        public int $fileMapped,
        public int $fileWriteback,
        public int $inactiveAnon,
        public int $inactiveFile,
        public int $kernelStack,
        public int $pgactivate,
        public int $pgdeactivate,
        public int $pgfault,
        public int $pglazyfree,
        public int $pglazyfreed,
        public int $pgmajfault,
        public int $pgrefill,
        public int $pgscan,
        public int $pgsteal,
        public int $shmem,
        public int $slab,
        public int $slabReclaimable,
        public int $slabUnreclaimable,
        public int $sock,
        public int $thpCollapseAlloc,
        public int $thpFaultAlloc,
        public int $unevictable,
        public int $workingsetActivate,
        public int $workingsetNodereclaim,
        public int $workingsetRefault,
    ) {}
}
