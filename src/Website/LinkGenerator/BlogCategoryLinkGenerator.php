<?php

namespace App\Website\LinkGenerator;

use Pimcore\Model\DataObject\BlogCategory;
use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogCategoryLinkGenerator implements LinkGeneratorInterface
{

    public function generate(object $object, array $params = []): string
    {

        if ($object instanceof BlogCategory && $object->getPublished()) {
            return '/kategorie/' . $object->getSlug();
        }
        throw new NotFoundHttpException();

    }
}
