<?php

namespace Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint;

final readonly class ShortenedUrlData {
	public function __construct(
		public string $id,
		public string $originalUrl,
		public string $shortenedUrl
	) {}
}