<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Document\Renderer\DocumentRenderer;
use Pimcore\Model\Document\Page;
use Symfony\Component\HttpFoundation\Response;

abstract class BlogController extends FrontendController
{

    public function __construct(protected DocumentRenderer $renderer)
    {
    }

    private function getPageParams(): array
    {
        $params = [];

        return $params;
    }



    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $document = $this->document;

        if ($document) {
            $parameters['renderer'] = $this->renderer;
            $parameters['document'] = $document;
            $parameters['footer_snippet'] = $document->getProperty('footer_snippet');
        }

        $parameters = array_merge($this->getPageParams(), $parameters);
        return parent::render($view, $parameters, $response);
    }

}
