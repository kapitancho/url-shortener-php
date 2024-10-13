<?php

namespace Walnut\UrlShortener\Lib;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Walnut\Lib\Http\Mapper\ResponseBuilder;
use Walnut\Lib\JsonSerializer\JsonSerializer;

final readonly class PsrResponseBuilder implements ResponseBuilder {

	public function __construct(
		private StreamFactoryInterface $streamFactory,
		private ResponseFactoryInterface $responseFactory,
		private JsonSerializer $jsonSerializer
	) {}

	public function emptyResponse(int $code = 200): ResponseInterface {
		return $this->responseFactory->createResponse($code);
	}

	public function contentResponse(string $content, int $code = 200): ResponseInterface {
		return $this->emptyResponse($code)->withBody(
			$this->streamFactory->createStream($content)
		);
	}

	public function textResponse(string $text, int $code = 200): ResponseInterface {
		return $this->contentResponse($text, $code)
			->withHeader(self::CONTENT_TYPE_HEADER, self::CONTENT_TYPE_TEXT);
	}

	public function jsonResponse(mixed $value, int $code = 200): ResponseInterface {
		return $this->contentResponse(
			$this->jsonSerializer->encode($value), $code
		)->withHeader(self::CONTENT_TYPE_HEADER, self::CONTENT_TYPE_JSON);
	}

	public function htmlResponse(string $html, int $code = 200): ResponseInterface {
		return $this->contentResponse($html, $code)
			->withHeader(self::CONTENT_TYPE_HEADER, self::CONTENT_TYPE_HTML);
	}

}