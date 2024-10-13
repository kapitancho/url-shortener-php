<?php

namespace Walnut\UrlShortener\Module\ShortUrl\Model\Implementation;

use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\ShortenedUrlData;
use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\UnknownUrl;

interface ShortenedUrlRepository {
	public function store(ShortenedUrlData $shortenedUrl): void;
	/** @throws UnknownUrl */
	public function getByShortUrl(string $shortUrl): ShortenedUrlData;
	/** @throws UnknownUrl */
	public function getById(string $id): ShortenedUrlData;
	/** @throws UnknownUrl */
	public function removeById(string $id): void;
}