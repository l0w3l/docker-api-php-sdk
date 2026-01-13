<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

$clientFactory = new \Lowel\Docker\ClientFactory;

var_dump(
    $clientFactory->getClientWithHandler()
        ->containerList()
);
