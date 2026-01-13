<?php

declare(strict_types=1);

namespace Lowel\Docker\Response\DTO\List;

class ContainerListFactory
{
    public static function fromArray(array $data): ContainerListItem
    {
        return new ContainerListItem(
            Id: $data['Id'],
            Names: $data['Names'],
            Image: $data['Image'],
            ImageID: $data['ImageID'],
            ImageManifestDescriptor: ($data['ImageManifestDescriptor'] ?? false) ? self::createImageManifestDescriptor($data['ImageManifestDescriptor']) : null,
            Command: $data['Command'],
            Created: (new \DateTimeImmutable)->setTimestamp($data['Created']),
            Ports: array_map(fn ($p) => new Port(
                PrivatePort: $p['PrivatePort'],
                PublicPort: $p['PublicPort'] ?? null,
                Type: $p['Type']
            ), $data['Ports']),
            SizeRw: $data['SizeRw'] ?? null,
            SizeRootFs: $data['SizeRootFs'] ?? null,
            Labels: $data['Labels'],
            State: $data['State'],
            Status: $data['Status'],
            HostConfig: new HostConfig(
                NetworkMode: $data['HostConfig']['NetworkMode'] ?? null,
                Annotations: $data['HostConfig']['Annotations'] ?? null
            ),
            NetworkSettings: new NetworkSettings(
                Networks: array_map(
                    fn ($net) => new NetworkProperty(
                        IPAMConfig: new IPAMConfig(
                            IPv4Address: $net['IPAMConfig']['IPv4Address'] ?? null,
                            IPv6Address: $net['IPAMConfig']['IPv6Address'] ?? null,
                            LinkLocalIPs: $net['IPAMConfig']['LinkLocalIPs'] ?? null
                        ),
                        Links: $net['Links'] ?? null,
                        MacAddress: $net['MacAddress'],
                        Aliases: $net['Aliases'] ?? null,
                        DriverOpts: $net['DriverOpts'] ?? null,
                        GwPriority: $net['GwPriority'] ?? null,
                        NetworkID: $net['NetworkID'],
                        EndpointID: $net['EndpointID'],
                        Gateway: $net['Gateway'],
                        IPAddress: $net['IPAddress'],
                        IPPrefixLen: $net['IPPrefixLen'],
                        IPv6Gateway: $net['IPv6Gateway'],
                        GlobalIPv6Address: $net['GlobalIPv6Address'],
                        GlobalIPv6PrefixLen: $net['GlobalIPv6PrefixLen'],
                        DNSNames: $net['DNSNames'] ?? null
                    ),
                    $data['NetworkSettings']['Networks']
                )
            ),
            Mounts: array_map(fn ($m) => new Mount(
                Type: $m['Type'],
                Name: $m['Name'] ?? null,
                Source: $m['Source'],
                Destination: $m['Destination'],
                Driver: $m['Driver'] ?? null,
                Mode: $m['Mode'],
                RW: $m['RW'],
                Propagation: $m['Propagation']
            ), $data['Mounts'])
        );
    }

    private static function createImageManifestDescriptor(array $data): ImageManifestDescriptor
    {
        return new ImageManifestDescriptor(
            mediaType: $data['mediaType'],
            digest: $data['digest'],
            size: $data['size'],
            urls: $data['urls'],
            annotations: $data['annotations'],
            data: $data['data'] ?? null,
            platform: new Platform(
                architecture: $data['platform']['architecture'],
                os: $data['platform']['os'],
                osVersion: $data['platform']['os.version'],
                osFeatures: $data['platform']['os.features'],
                variant: $data['platform']['variant'] ?? null
            ),
            artifactType: $data['artifactType'] ?? null
        );
    }
}
