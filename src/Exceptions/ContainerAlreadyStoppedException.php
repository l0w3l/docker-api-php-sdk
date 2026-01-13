<?php

declare(strict_types=1);

namespace Lowel\Docker\Exceptions;

class ContainerAlreadyStoppedException extends DockerClientException
{
    const MESSAGE = "Container '%s' already stopped!";

    public function __construct(string $containerName)
    {
        $message = $this->format(self::MESSAGE, $containerName);

        parent::__construct($message);
    }
}
