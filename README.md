# someniatko/amqp-url-parser

AMQP 0-9-1 URL parser.

Tested against all examples from the [RabbitMQ URI specification](https://www.rabbitmq.com/uri-spec.html) (Appendix A)

Based on [league/uri](https://github.com/thephpleague/uri).

## Usage

`composer install someniatko/amqp-url-parser`

```php
<?php

declare(strict_types=1);

namespace YourCode;

use Someniatko\AmqpUrlParser\Parser;

$url = Parser::parse('amqp://username:password@host:1234/vhost');

$host = $url->host;
$port = $url->port;
$username = $url->username;
$password = $url->password;
$vhost = $url->vhost;
```
