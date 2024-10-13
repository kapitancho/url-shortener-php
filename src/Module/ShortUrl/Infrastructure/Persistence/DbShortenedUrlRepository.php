<?php

namespace Walnut\UrlShortener\Module\ShortUrl\Infrastructure\Persistence;

use Walnut\Lib\Db\Query\QueryExecutor;
use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\ShortenedUrlData;
use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\UnknownUrl;
use Walnut\UrlShortener\Module\ShortUrl\Model\Implementation\ShortenedUrlRepository;

final readonly class DbShortenedUrlRepository implements ShortenedUrlRepository {

	public function __construct(
		private QueryExecutor $queryExecutor
	) {}

	/** @throws UnknownUrl */
	public function store(ShortenedUrlData $shortenedUrl): void {
		$this->queryExecutor->execute(
			'INSERT INTO shortened_urls (id, url, short_url) VALUES (:id, :url, :short_url)', [
				'id' => $shortenedUrl->id,
				'url' => $shortenedUrl->originalUrl,
				'short_url' => $shortenedUrl->shortenedUrl
			]
		);
	}

	/** @throws UnknownUrl */
	public function getByShortUrl(string $shortUrl): ShortenedUrlData {
		$record = $this->queryExecutor->execute(
			"SELECT id, url, short_url FROM shortened_urls WHERE short_url = :short_url", ['short_url' => $shortUrl]
		)->first();
		if (!$record) {
			UnknownUrl::withShortenedUrl($shortUrl);
		}
		return new ShortenedUrlData(
			$record['id'],
			$record['url'],
			$record['short_url']
		);
	}

	public function getById(string $id): ShortenedUrlData {
		$record = $this->queryExecutor->execute(
			"SELECT id, url, short_url FROM shortened_urls WHERE id = :id", ['id' => $id]
		)->first();
		if (!$record) {
			UnknownUrl::withId($id);
		}
		return new ShortenedUrlData(
			$record['id'],
			$record['url'],
			$record['short_url']
		);
	}

	/** @throws UnknownUrl */
	public function removeById(string $id): void {
		$existingId = $this->queryExecutor->execute(
			"SELECT id FROM shortened_urls WHERE id = :id", ['id' => $id]
		)->singleValue();
		if (!$existingId) {
			UnknownUrl::withId($id);
		}
		$this->queryExecutor->execute(
			"DELETE FROM shortened_urls WHERE id = :id", ['id' => $id]
		);
	}
}