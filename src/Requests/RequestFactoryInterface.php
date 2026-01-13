<?php

declare(strict_types=1);

namespace Lowel\Docker\Requests;

use Psr\Http\Message\RequestInterface;

interface RequestFactoryInterface
{
    public function get(RequestTypeEnum $requestTypeEnum, array $params, $data): RequestInterface;

    public function post(RequestTypeEnum $requestTypeEnum, array $params, $data): RequestInterface;
}
