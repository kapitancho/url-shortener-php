<?php

namespace Walnut\Config;

use Walnut\Lib\Http\RequestHandler\CompositeHandler;
use Walnut\Lib\Http\RequestHandler\ControllerExceptionHandler;
use Walnut\Lib\Http\RequestHandler\CorsHandler;
use Walnut\Lib\Http\RequestHandler\ErrorLoggerHandler;
use Walnut\Lib\Http\RequestHandler\LookupRouter;
use Walnut\Lib\Http\RequestHandler\NoCacheHandler;
use Walnut\Lib\Http\RequestHandler\NotFoundHandler;
use Walnut\Lib\Http\RequestHandler\RoutePathFinder;
use Walnut\Lib\Http\RequestHandler\UncaughtExceptionHandler;

return [
	CompositeHandler::class                     => static fn(
		NotFoundHandler                         $notFoundHandler,
		CorsHandler                             $corsHandler,
		NoCacheHandler                          $noCacheHandler,
		ErrorLoggerHandler                      $errorLoggerHandler,
		UncaughtExceptionHandler                $uncaughtExceptionHandler,
		ControllerExceptionHandler              $controllerExceptionHandler,
		RoutePathFinder                         $routePathFinder,
		LookupRouter                            $lookupRouter
	): CompositeHandler => new CompositeHandler(
		$notFoundHandler, [
			$noCacheHandler,
			$corsHandler,
			$uncaughtExceptionHandler,
			$controllerExceptionHandler,
			$routePathFinder,
			$lookupRouter
		]
	),
	LookupRouter::class => ['routerMapping' => require __DIR__ . '/routes.config.php'],
	RoutePathFinder::class => ['availableRoutes' => array_keys(require __DIR__ . '/routes.config.php')],
];