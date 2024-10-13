<?php

namespace Walnut\UrlShortener\Module\ShortUrl\Model\Implementation;

use Psr\Http\Message\UriInterface;
use Walnut\Lib\IdentityGenerator\IdentityGenerator;
use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\ShortenedUrlData;
use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\ShortenedUrlList as ShortenedUrlListInterface;
use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\UnknownUrl;

final readonly class ShortenedUrlList implements ShortenedUrlListInterface {
	public function __construct(
		private ShortenedUrlRepository $urlShortenerRepository,
		private ShortUrlGenerator      $shortUrlGenerator,
		private IdentityGenerator      $identityGenerator
	) {}

	private function value(ShortenedUrlData $shortenedUrl): ShortenedUrl {
		return new ShortenedUrl(
			$this->urlShortenerRepository,
			$shortenedUrl
		);
	}

	public function shortenUrl(UriInterface $url): ShortenedUrl {
		$shortenedUrl = new ShortenedUrlData(
			$this->identityGenerator->generateId(),
			(string)$url,
			$this->shortUrlGenerator->generate(),
		);
		$this->urlShortenerRepository->store($shortenedUrl);
		return $this->value($shortenedUrl);
	}

	/** @throws UnknownUrl */
	public function getByShortenedUrl(string $shortUrl): ShortenedUrl {
		return $this->value(
			$this->urlShortenerRepository->getByShortUrl($shortUrl)
		);
	}

	/** @throws UnknownUrl */
	public function getById(string $id): ShortenedUrl {
		return $this->value(
			$this->urlShortenerRepository->getById($id)
		);
	}
}