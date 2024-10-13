<?php

namespace Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint;

use RuntimeException;

final class UnknownUrl extends RuntimeException {
	private function __construct(string $errorMessage) {
		parent::__construct($errorMessage);
	}
	/** @throws self */
	public static function withId(string $id): never {
		throw new self(sprintf("Unknown entry with ID: %s", $id));
	}
	/** @throws self */
	public static function withShortenedUrl(string $shortenedUrl): never {
		throw new self(sprintf("Unknown entry with shortened URL: %s", $shortenedUrl));
	}
}