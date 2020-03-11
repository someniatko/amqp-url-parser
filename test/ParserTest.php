<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use Someniatko\AmqpUrlParser\AmqpUrl;
use Someniatko\AmqpUrlParser\Parser;

final class ParserTest extends TestCase
{
    /** @dataProvider urlProvider */
    public function test(string $rawUrl, AmqpUrl $expectedParsedUrl): void
    {
        $parsedUrl = Parser::parse($rawUrl);

        $this->assertSame($expectedParsedUrl->username, $parsedUrl->username);
        $this->assertSame($expectedParsedUrl->password, $parsedUrl->password);
        $this->assertSame($expectedParsedUrl->host, $parsedUrl->host);
        $this->assertSame($expectedParsedUrl->port, $parsedUrl->port);
        $this->assertSame($expectedParsedUrl->vhost, $parsedUrl->vhost);
    }

    public function urlProvider(): iterable
    {
        // https://www.rabbitmq.com/uri-spec.html
        // examples taken from Appendix A:
        yield [
            'amqp://user:pass@host:10000/vhost',
            new AmqpUrl('user', 'pass', 'host', 10000, 'vhost')
        ];

        yield [
            'amqp://user%61:%61pass@ho%61st:10000/v%2fhost',
            new AmqpUrl('usera', 'apass', 'hoast', 10000, 'v/host')
        ];

        yield [
            'amqp://',
            new AmqpUrl(null, null, null, null, null)
        ];

        yield [
            'amqp://:@/',
            new AmqpUrl('', '', null, null, '')
        ];

        yield [
            'amqp://user@',
            new AmqpUrl('user', null, null, null, null)
        ];

        yield [
            'amqp://user:pass@',
            new AmqpUrl('user', 'pass', null, null, null)
        ];

        yield [
            'amqp://host',
            new AmqpUrl(null, null, 'host', null, null)
        ];

        yield [
            'amqp://:10000',
            new AmqpUrl(null, null, null, 10000, null)
        ];

        yield [
            'amqp:///vhost',
            new AmqpUrl(null, null, null, null, 'vhost')
        ];

        yield [
            'amqp://host/',
            new AmqpUrl(null, null, 'host', null, '')
        ];

        yield [
            'amqp://host/%2f',
            new AmqpUrl(null, null, 'host', null, '/')
        ];

        yield [
            'amqp://[::1]',
            new AmqpUrl(null, null, '[::1]', null, null)
        ];
    }

    public function testItThrowsExceptionOnForeignSchemas(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        Parser::parse('http://example.com');
    }
}
