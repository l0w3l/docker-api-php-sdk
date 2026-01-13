<?php

declare(strict_types=1);

namespace Lowel\Docker\Exceptions;

class ContainerNotFoundException extends DockerClientException
{
    const MESSAGE = "Container '%s' not found!";

    public function __construct(string $containerName)
    {
        $message = $this->format(self::MESSAGE, $containerName);

        parent::__construct($message);
    }
}
