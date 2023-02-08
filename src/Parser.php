<?php

declare(strict_types=1);

namespace Someniatko\AmqpUrlParser;

use League\Uri\UriString;

final class Parser
{
    /** @throws \UnexpectedValueException if the URI scheme is not amqp:// */
    public static function parse(string $url): AmqpUrl
    {
        $parts = UriString::parse($url);

        if ($parts['scheme'] !== 'amqp') {
            throw new \UnexpectedValueException('Scheme must be "amqp"');
        }

        return new AmqpUrl(
            self::urlDecodeNullable($parts['user'] ?? null),
            self::urlDecodeNullable($parts['pass'] ?? null),
            self::urlDecodeNullable($parts['host'] ?: null),
            $parts['port'] ?? null,
            ! empty($parts['path'])
                ? urldecode(substr($parts['path'], 1))
                : null
        );
    }

    private static function urlDecodeNullable(?string $str): ?string
    {
        return ($str === null)
            ? null
            : urldecode($str);
    }
}
