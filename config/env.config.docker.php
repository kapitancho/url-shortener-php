<?php

namespace Walnut\Config;

use Walnut\Lib\Db\Pdo\PdoConnector;
use Walnut\UrlShortener\Module\ShortUrl\Infrastructure\Controller\UrlShortenerController;

return [
	UrlShortenerController::class => [
		'webRoot' => 'http://localhost:8137'
	],
	PdoConnector::class => [
		'dsn' => 'sqlite:' . __DIR__ . '/../data/url-shortener.sqlite',
		'username' => '',
		'password' => '',
	]
];