<?php

namespace Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint;

use Psr\Http\Message\UriInterface;

interface ShortenedUrlList {
	public function shortenUrl(UriInterface $url): ShortenedUrl;
	/** @throws UnknownUrl */
	public function getByShortenedUrl(string $shortUrl): ShortenedUrl;
	/** @throws UnknownUrl */
	public function getById(string $id): ShortenedUrl;
}