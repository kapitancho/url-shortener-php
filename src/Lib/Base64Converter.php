<?php

namespace Walnut\UrlShortener\Lib;

final class Base64Converter {

	public function encode(string $data): string {
		return base64_encode($data);
	}

	public function urlEncode(string $data): string {
	    $encoded = $this->encode($data);
	    $encoded = str_replace(['+', '/'], ['-', '_'], $encoded);
		return rtrim($encoded, '=');
	}
}