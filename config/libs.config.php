<?php

namespace Walnut\Config;

use Walnut\Lib\Data\Hydrator\Builder\ClassDataBuilder;
use Walnut\Lib\Data\Hydrator\Builder\ClassDataBuilderCache;
use Walnut\Lib\Data\Hydrator\Builder\ReflectionClassDataBuilder;
use Walnut\Lib\Data\Hydrator\ClassHydrator;
use Walnut\Lib\Data\Hydrator\ClassRefHydrator;
use Walnut\Lib\Data\Hydrator\CompositeValueHydrator;
use Walnut\Lib\Data\Hydrator\DefaultClassHydrator;
use Walnut\Lib\Data\Hydrator\DefaultImporter;
use Walnut\Lib\Db\DataModel\DataModelBuilder;
use Walnut\Lib\Db\DataModel\ReflectionDataModelBuilder;
use Walnut\Lib\Db\Orm\DataModelFactory;
use Walnut\Lib\Db\Orm\RelationalStorageFactory;
use Walnut\Lib\Db\Pdo\PdoTransactionalQueryExecutor;
use Walnut\Lib\Db\Query\QueryExecutor;
use Walnut\Lib\Http\Controller\ControllerAutoWireHelper;
use Walnut\Lib\Http\Controller\ControllerHelper;
use Walnut\Lib\Http\Mapper\ResponseBuilder;
use Walnut\Lib\Http\Mapper\ResponseRenderer;
use Walnut\Lib\Http\Mapper\ViewRenderer;
use Walnut\Lib\IdentityGenerator\CombUuidGenerator;
use Walnut\Lib\IdentityGenerator\IdentityGenerator;
use Walnut\Lib\JsonSerializer\JsonSerializer;
use Walnut\Lib\JsonSerializer\PhpJsonSerializer;
use Walnut\Lib\Http\TemplateRenderer\PerFileTemplateNameMapper;
use Walnut\Lib\Http\TemplateRenderer\PhpTemplateRenderer;
use Walnut\Lib\Http\TemplateRenderer\TemplateNameMapper;
use Walnut\Lib\Http\TemplateRenderer\TemplateRenderer;
use Walnut\Lib\Http\ViewRenderer\LookupViewMapper;
use Walnut\Lib\Http\ViewRenderer\ViewMapper;
use Walnut\Lib\Http\ViewRenderer\ViewRendererAdapter;
use Walnut\UrlShortener\Lib\PsrResponseBuilder;
use Walnut\UrlShortener\Lib\TemplateRendererAdapter;

return [
	//Walnut
	TemplateNameMapper::class                   => PerFileTemplateNameMapper::class,

	//Template Renderer
	TemplateRenderer::class                     => PhpTemplateRenderer::class,

	//Json Serializer
	JsonSerializer::class                       => PhpJsonSerializer::class,

	//Identity Generator
	IdentityGenerator::class                    => CombUuidGenerator::class,

	//Db Query
	QueryExecutor::class                        => PdoTransactionalQueryExecutor::class,

	//Db Data Model
	DataModelBuilder::class                     => ReflectionDataModelBuilder::class,

	//Data Type
	ClassRefHydrator::class                     => DefaultImporter::class,

	//Http Mapper
	ResponseRenderer::class                     => TemplateRendererAdapter::class,
	ViewRenderer::class                         => ViewRendererAdapter::class,
	ResponseBuilder::class                      => PsrResponseBuilder::class,
	ViewMapper::class                           => LookupViewMapper::class,

	//Http Controller
	ControllerHelper::class                     => ControllerAutoWireHelper::class,

	//Data Type Importer
	ClassHydrator::class                        => DefaultClassHydrator::class,
	DefaultImporter::class                      => ['importPath' => ''],
	ClassDataBuilder::class                     => static fn(
		ReflectionClassDataBuilder $reflectionClassDataBuilder
	) => new ClassDataBuilderCache($reflectionClassDataBuilder),
	CompositeValueHydrator::class               => DefaultImporter::class,

	//Db Orm
	RelationalStorageFactory::class             => DataModelFactory::class,

];