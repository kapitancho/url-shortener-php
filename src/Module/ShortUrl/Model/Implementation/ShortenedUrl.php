<?php

namespace Walnut\UrlShortener\Module\ShortUrl\Model\Implementation;

use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\ShortenedUrl as ShortenedUrlInterface;
use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\ShortenedUrlData;

final readonly class ShortenedUrl implements ShortenedUrlInterface {
	public function __construct(
		private ShortenedUrlRepository $urlShortenerRepository,
		private ShortenedUrlData       $data
	) {}

	public function data(): ShortenedUrlData {
		return $this->data;
	}

	public function remove(): void {
		$this->urlShortenerRepository->removeById($this->data->id);
	}
}