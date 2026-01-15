<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\Inspect;

final class ContainerFactory
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): Container
    {
        $state = self::createState($data['State']);
        $imageManifest = match (($data['ImageManifestDescriptor'] ?? null) !== null) {
            true => self::createImageManifest($data['ImageManifestDescriptor']),
            false => null,
        };
        $graphDriver = match (($data['GraphDriver'] ?? null) !== null) {
            true => self::createGraphDriver($data['GraphDriver']),
            false => null,
        };

        return new Container(
            Id: $data['Id'],
            Created: $data['Created'],
            Path: $data['Path'],
            Args: $data['Args'] ?? [],
            State: $state,
            Image: $data['Image'],
            ResolvConfPath: $data['ResolvConfPath'],
            HostnamePath: $data['HostnamePath'],
            HostsPath: $data['HostsPath'],
            LogPath: $data['LogPath'],
            Name: $data['Name'],
            RestartCount: $data['RestartCount'],
            Driver: $data['Driver'],
            Platform: $data['Platform'],
            ImageManifestDescriptor: $imageManifest,
            MountLabel: $data['MountLabel'],
            ProcessLabel: $data['ProcessLabel'],
            AppArmorProfile: $data['AppArmorProfile'],
            ExecIDs: $data['ExecIDs'] ?? [],
            GraphDriver: $graphDriver,
            SizeRw: $data['SizeRw'] ?? null,
            SizeRootFs: $data['SizeRootFs'] ?? null
        );
    }

    private static function createState(array $data): State
    {
        $health = match (($data['Health'] ?? null) !== null) {
            true => self::createHealth($data['Health']),
            false => null,
        };

        return new State(
            Status: $data['Status'],
            Running: $data['Running'],
            Paused: $data['Paused'],
            Restarting: $data['Restarting'],
            OOMKilled: $data['OOMKilled'],
            Dead: $data['Dead'],
            Pid: $data['Pid'],
            ExitCode: $data['ExitCode'],
            Error: $data['Error'],
            StartedAt: $data['StartedAt'],
            FinishedAt: $data['FinishedAt'],
            Health: $health
        );
    }

    private static function createHealth(array $data): Health
    {
        $logs = array_map(
            fn (array $log): LogEntry => new LogEntry(
                Start: $log['Start'],
                End: $log['End'],
                ExitCode: $log['ExitCode'],
                Output: $log['Output']
            ),
            $data['Log'] ?? []
        );

        return new Health(
            Status: $data['Status'],
            FailingStreak: $data['FailingStreak'],
            Log: $logs
        );
    }

    private static function createPlatform(array $data): Platform
    {
        return new Platform(
            architecture: $data['architecture'] ?? null,
            os: $data['os'] ?? null,
            os_version: $data['os.version'] ?? null,
            os_features: $data['os.features'] ?? [],
            variant: $data['variant'] ?? null
        );
    }

    private static function createImageManifest(array $data): ImageManifestDescriptor
    {

        $platform = match (($data['platform'] ?? null) !== null) {
            true => self::createPlatform($data['platform']),
            false => null,
        };

        return new ImageManifestDescriptor(
            mediaType: $data['mediaType'],
            digest: $data['digest'],
            size: $data['size'],
            urls: $data['urls'] ?? null,
            annotations: $data['annotations'] ?? [],
            data: $data['data'] ?? null,
            platform: $platform,
            artifactType: $data['artifactType'] ?? null
        );
    }

    private static function createGraphDriver(array $data): GraphDriver
    {
        $graphData = new GraphDriverData(
            MergedDir: $data['Data']['MergedDir'],
            UpperDir: $data['Data']['UpperDir'],
            WorkDir: $data['Data']['WorkDir']
        );

        return new GraphDriver(
            Name: $data['Name'],
            Data: $graphData
        );
    }
}
