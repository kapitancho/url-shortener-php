<?php

namespace Walnut\UrlShortener\Lib;

use Walnut\Lib\Http\Mapper\ResponseRenderer;
use Walnut\Lib\Http\TemplateRenderer\TemplateRenderer;

final readonly class TemplateRendererAdapter implements ResponseRenderer {
	public function __construct(
		private TemplateRenderer $templateRenderer
	) {}

	public function render(string $templateName, mixed $viewModel = null): string {
		return $this->templateRenderer->render($templateName, $viewModel);
	}
}