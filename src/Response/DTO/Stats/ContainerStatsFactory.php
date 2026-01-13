<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Stats;

use DateMalformedStringException;
use DateTimeImmutable;

final class ContainerStatsFactory
{
    /**
     * @throws DateMalformedStringException
     */
    public static function fromArray(array $data): ContainerStats
    {
        return new ContainerStats(
            name: $data['name'],
            id: $data['id'],
            read: new DateTimeImmutable($data['read']),
            preread: new DateTimeImmutable($data['preread']),
            pidsStats: self::pidsStats($data['pids_stats']),
            blkioStats: self::blkioStats($data['blkio_stats']),
            numProcs: $data['num_procs'],
            storageStats: self::storageStats($data['storage_stats']),
            cpuStats: self::cpuStats($data['cpu_stats']),
            preCpuStats: self::cpuStats($data['precpu_stats']),
            memoryStats: self::memoryStats($data['memory_stats']),
            networks: self::networks($data['networks'] ?? []),
        );
    }

    private static function pidsStats(array $data): PidsStats
    {
        return new PidsStats(
            current: $data['current'],
            limit: (string) $data['limit'],
        );
    }

    private static function blkioStats(array $data): BlkioStats
    {
        return new BlkioStats(
            ioServiceBytesRecursive: self::blkioEntries($data['io_service_bytes_recursive'] ?? null),
            ioServicedRecursive: $data['io_serviced_recursive'] ?? null,
            ioQueueRecursive: $data['io_queue_recursive'] ?? null,
            ioServiceTimeRecursive: $data['io_service_time_recursive'] ?? null,
            ioWaitTimeRecursive: $data['io_wait_time_recursive'] ?? null,
            ioMergedRecursive: $data['io_merged_recursive'] ?? null,
            ioTimeRecursive: $data['io_time_recursive'] ?? null,
            sectorsRecursive: $data['sectors_recursive'] ?? null,
        );
    }

    /**
     * @return BlkioEntry[]|null
     */
    private static function blkioEntries(?array $items): ?array
    {
        if ($items === null) {
            return null;
        }

        return array_map(
            fn (array $item) => new BlkioEntry(
                major: $item['major'],
                minor: $item['minor'],
                op: $item['op'],
                value: $item['value'],
            ),
            $items
        );
    }

    private static function storageStats(array $data): ?StorageStats
    {
        if (empty($data)) {
            return null;
        } else {
            return new StorageStats(
                readCountNormalized: $data['read_count_normalized'],
                readSizeBytes: $data['read_size_bytes'],
                writeCountNormalized: $data['write_count_normalized'],
                writeSizeBytes: $data['write_size_bytes'],
            );
        }
    }

    private static function cpuStats(array $data): CpuStats
    {
        return new CpuStats(
            cpuUsage: self::cpuUsage($data['cpu_usage']),
            systemCpuUsage: $data['system_cpu_usage'],
            onlineCpus: $data['online_cpus'],
            throttlingData: self::throttlingData($data['throttling_data']),
        );
    }

    private static function cpuUsage(array $data): CpuUsage
    {
        return new CpuUsage(
            totalUsage: $data['total_usage'],
            percpuUsage: $data['percpu_usage'] ?? [],
            usageInKernelmode: $data['usage_in_kernelmode'],
            usageInUsermode: $data['usage_in_usermode'],
        );
    }

    private static function throttlingData(array $data): ThrottlingData
    {
        return new ThrottlingData(
            periods: $data['periods'],
            throttledPeriods: $data['throttled_periods'],
            throttledTime: $data['throttled_time'],
        );
    }

    private static function memoryStats(array $data): MemoryStats
    {
        return new MemoryStats(
            usage: $data['usage'],
            maxUsage: $data['max_usage'] ?? null,
            stats: self::memoryDetailedStats($data['stats']),
            failcnt: $data['failcnt'] ?? null,
            limit: $data['limit'],
            commitbytes: $data['commitbytes'] ?? null,
            commitpeakbytes: $data['commitpeakbytes'] ?? null,
            privateworkingset: $data['privateworkingset'] ?? null,
        );
    }

    private static function memoryDetailedStats(array $data): MemoryDetailedStats
    {
        return new MemoryDetailedStats(
            activeAnon: $data['active_anon'],
            activeFile: $data['active_file'],
            anon: $data['anon'],
            anonThp: $data['anon_thp'],
            file: $data['file'],
            fileDirty: $data['file_dirty'],
            fileMapped: $data['file_mapped'],
            fileWriteback: $data['file_writeback'],
            inactiveAnon: $data['inactive_anon'],
            inactiveFile: $data['inactive_file'],
            kernelStack: $data['kernel_stack'],
            pgactivate: $data['pgactivate'],
            pgdeactivate: $data['pgdeactivate'],
            pgfault: $data['pgfault'],
            pglazyfree: $data['pglazyfree'],
            pglazyfreed: $data['pglazyfreed'],
            pgmajfault: $data['pgmajfault'],
            pgrefill: $data['pgrefill'],
            pgscan: $data['pgscan'],
            pgsteal: $data['pgsteal'],
            shmem: $data['shmem'],
            slab: $data['slab'],
            slabReclaimable: $data['slab_reclaimable'],
            slabUnreclaimable: $data['slab_unreclaimable'],
            sock: $data['sock'],
            thpCollapseAlloc: $data['thp_collapse_alloc'],
            thpFaultAlloc: $data['thp_fault_alloc'],
            unevictable: $data['unevictable'],
            workingsetActivate: $data['workingset_activate'],
            workingsetNodereclaim: $data['workingset_nodereclaim'],
            workingsetRefault: $data['workingset_refault'],
        );
    }

    /**
     * @return array<string, NetworkStats>
     */
    private static function networks(array $data): array
    {
        $result = [];

        foreach ($data as $iface => $stats) {
            $result[$iface] = new NetworkStats(
                rxBytes: $stats['rx_bytes'],
                rxDropped: $stats['rx_dropped'],
                rxErrors: $stats['rx_errors'],
                rxPackets: $stats['rx_packets'],
                txBytes: $stats['tx_bytes'],
                txDropped: $stats['tx_dropped'],
                txErrors: $stats['tx_errors'],
                txPackets: $stats['tx_packets'],
            );
        }

        return $result;
    }
}
