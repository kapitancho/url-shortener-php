<?php

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Walnut\Lib\Container\Container;
use Walnut\Lib\Http\RequestHandler\CompositeHandler;

require_once __DIR__ . '/vendor/autoload.php';
spl_autoload_register();

function emitResponse(ResponseInterface $response): void {
    // Emit status line
    header(sprintf(
        'HTTP/%s %d %s',
        $response->getProtocolVersion(),
        $response->getStatusCode(),
        $response->getReasonPhrase()
    ));

    // Emit headers
    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) {
            header(sprintf('%s: %s', $name, $value), false);
        }
    }

    // Emit body
    echo $response->getBody();
}

emitResponse($response = (new Container(include __DIR__ . '/config/di.config.php'))->instanceOf(CompositeHandler::class)
	->handle(ServerRequest::fromGlobals()));
