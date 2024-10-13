<?php

namespace Walnut\UrlShortener\Module\ShortUrl\Model\Implementation;

use Walnut\UrlShortener\Lib\Base64Converter;

final readonly class ShortUrlGenerator {
	public function __construct(
		private Base64Converter $base64Converter,
	) {}

	public function generate(): string {
		return $this->base64Converter->urlEncode(random_bytes(6));
	}
}