<?php

namespace Walnut\UrlShortener\Module\ShortUrl\Infrastructure\Controller;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriFactoryInterface;
use Walnut\Lib\Http\Mapper\Attribute\ErrorHandler;
use Walnut\Lib\Http\Mapper\Attribute\RequestMapper\FromForm;
use Walnut\Lib\Http\Mapper\Attribute\RequestMapper\FromRoute;
use Walnut\Lib\Http\Mapper\Attribute\RequestMatch\HttpDelete;
use Walnut\Lib\Http\Mapper\Attribute\RequestMatch\HttpGet;
use Walnut\Lib\Http\Mapper\Attribute\RequestMatch\HttpPost;
use Walnut\Lib\Http\Mapper\Attribute\ResponseMapper\JsonResponseBody;
use Walnut\Lib\Http\Mapper\Attribute\ResponseMapper\NoContentResponse;
use Walnut\Lib\Http\Mapper\ResponseBuilder;
use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\ShortenedUrlList;
use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\UnknownUrl;

final readonly class UrlShortenerController {

	public function __construct(
		private ResponseBuilder $responseBuilder,
		private ShortenedUrlList $shortenedUrlList,
		private UriFactoryInterface $uriFactory,
		private string $webRoot
	) {}

	#[HttpPost, JsonResponseBody]
	public function shortenUrl(#[FromForm] string|null $url): array {
		$uri = $this->uriFactory->createUri($url);
		$shortenedUrl = $this->shortenedUrlList->shortenUrl($uri)->data();
		return [
			'id' => $shortenedUrl->id,
			'originalUrl' => $shortenedUrl->originalUrl,
			'shortenedUrl' => sprintf('%s/%s', $this->webRoot, $shortenedUrl->shortenedUrl)
		];
	}

	#[HttpDelete('/{id}'), NoContentResponse]
	public function removeShortenedUrl(#[FromRoute] string $id): void {
		$this->shortenedUrlList->getById($id)->remove();
	}

	#[HttpGet('/{shortUrl}')]
	public function forwardUrl(#[FromRoute] string $shortUrl): ResponseInterface {
		return $this->responseBuilder->emptyResponse(301)->withHeader(
			'Location',
			$this->shortenedUrlList->getByShortenedUrl($shortUrl)->data()->originalUrl
		);
	}

	#[ErrorHandler(InvalidArgumentException::class)]
	public function onInvalidArgumentsException(InvalidArgumentException $exception): ResponseInterface {
		return $this->responseBuilder->jsonResponse(
			['error' => $exception->getMessage()],
			400
		);
	}

	#[ErrorHandler(UnknownUrl::class)]
	public function onUnknownUrl(UnknownUrl $exception): ResponseInterface {
		return $this->responseBuilder->jsonResponse(
			['error' => $exception->getMessage()],
			404
		);
	}
}