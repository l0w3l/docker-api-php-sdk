<?php

declare(strict_types=1);

namespace Lowel\Docker\Exceptions;

class ContainerAlreadyStartedException extends DockerClientException
{
    const MESSAGE = "Container '%s' already started!";

    public function __construct(string $containerName)
    {
        $message = $this->format(self::MESSAGE, $containerName);

        parent::__construct($message);
    }
}
