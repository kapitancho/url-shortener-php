<?php

namespace Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint;

interface ShortenedUrl {
	public function remove(): void;
	public function data(): ShortenedUrlData;
}