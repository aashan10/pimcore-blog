<?php

namespace App\Website\PreviewGenerator;

use Pimcore\Model\DataObject\BlogCategory;
use Pimcore\Model\DataObject\ClassDefinition\PreviewGeneratorInterface;
use Pimcore\Model\DataObject\Concrete;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogCategoryPreviewGenerator implements PreviewGeneratorInterface
{

    public function generatePreviewUrl(Concrete $object, array $params): string
    {
        if ($object->getPublished() && $object instanceof BlogCategory) {
            return '/kategorie/' . $object->getSlug();
        }

        throw new NotFoundHttpException();
    }

    public function getPreviewConfig(Concrete $object): array
    {
        return [];
    }
}
