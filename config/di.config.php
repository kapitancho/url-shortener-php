<?php

namespace Walnut\Config;

use GuzzleHttp\Psr7\HttpFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Walnut\Lib\Http\TemplateRenderer\PerFileTemplateNameMapper;
use Walnut\Lib\Http\ViewRenderer\LookupViewMapper;
use Walnut\Lib\JsonSerializer\JsonSerializer;
use Walnut\Lib\JsonSerializer\PhpJsonSerializer;
use Walnut\UrlShortener\Module\ShortUrl\Infrastructure\Persistence\DbShortenedUrlRepository;
use Walnut\UrlShortener\Module\ShortUrl\Model\Blueprint\ShortenedUrlList as ShortenedUrlListInterface;
use Walnut\UrlShortener\Module\ShortUrl\Model\Implementation\ShortenedUrlList;
use Walnut\UrlShortener\Module\ShortUrl\Model\Implementation\ShortenedUrlRepository;

return [
	JsonSerializer::class => PhpJsonSerializer::class,
	ServerRequestFactoryInterface::class        => HttpFactory::class,
	RequestFactoryInterface::class              => HttpFactory::class,
	ResponseFactoryInterface::class             => HttpFactory::class,
	StreamFactoryInterface::class               => HttpFactory::class,
	UploadedFileFactoryInterface::class         => HttpFactory::class,
	UriFactoryInterface::class                  => HttpFactory::class,

	PerFileTemplateNameMapper::class            => [
		'baseDir'                               => __DIR__ . '/../templates',
		'fileExtension'                         => 'tpl.php'
	],

	//Http Mapper
	LookupViewMapper::class                     => ['mapping' => []],

	LoggerInterface::class => NullLogger::class,

	ShortenedUrlListInterface::class => ShortenedUrlList::class,
	ShortenedUrlRepository::class => DbShortenedUrlRepository::Class,

]
	+ (require(__DIR__ . '/libs.config.php'))
	+ (require(__DIR__ . '/http.config.php'))
	+ (require(__DIR__ . '/env.config.php'));