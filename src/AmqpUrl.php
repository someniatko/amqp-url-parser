<?php

declare(strict_types=1);

namespace Someniatko\AmqpUrlParser;

/** @psalm-immutable */
final class AmqpUrl
{
    public ?string $username;
    public ?string $password;
    public ?string $host;
    public ?int $port;
    public ?string $vhost;

    public function __construct(
        ?string $username,
        ?string $password,
        ?string $host,
        ?int $port,
        ?string $vhost
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
        $this->vhost = $vhost;
    }
}
