<?php

declare(strict_types=1);

namespace Someniatko\AmqpUrlParser;

/** @psalm-immutable */
final class AmqpUrl
{
    public function __construct(
        public ?string $username,
        public ?string $password,
        public ?string $host,
        public ?int $port,
        public ?string $vhost
    ) {}
}
