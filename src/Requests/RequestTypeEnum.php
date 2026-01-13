<?php

declare(strict_types=1);

namespace Lowel\Docker\Requests;

enum RequestTypeEnum: string
{
    /**
     * @link https://docs.docker.com/reference/api/engine/version/v1.51/#tag/Container/operation/ContainerList
     */
    case CONTAINER_LIST = '/containers/json';

    /**
     * @link https://docs.docker.com/reference/api/engine/version/v1.51/#tag/Container/operation/ContainerInspect
     */
    case CONTAINER_INSPECT = '/containers/{id}/json';

    /**
     * @link https://docs.docker.com/reference/api/engine/version/v1.51/#tag/Container/operation/ContainerStart
     */
    case CONTAINER_START = '/containers/{id}/start';

    /**
     * @link https://docs.docker.com/reference/api/engine/version/v1.51/#tag/Container/operation/ContainerStop
     */
    case CONTAINER_STOP = '/containers/{id}/stop';

    /**
     * @link https://docs.docker.com/reference/api/engine/version/v1.51/#tag/Container/operation/ContainerRestart
     */
    case CONTAINER_RESTART = '/containers/{id}/restart';

    /**
     * @link https://docs.docker.com/reference/api/engine/version/v1.51/#tag/Container/operation/ContainerExport
     */
    case CONTAINER_STATS = '/containers/{id}/stats';
}
