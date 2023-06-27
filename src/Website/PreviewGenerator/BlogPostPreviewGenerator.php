<?php

namespace App\Website\PreviewGenerator;

use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\DataObject\ClassDefinition\PreviewGeneratorInterface;
use Pimcore\Model\DataObject\Concrete;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogPostPreviewGenerator implements PreviewGeneratorInterface
{

    public function generatePreviewUrl(Concrete $object, array $params): string
    {
        if ($object->getPublished() && $object instanceof BlogPost) {
            return '/' . $object->getSlug();
        }

        throw new NotFoundHttpException();
    }

    public function getPreviewConfig(Concrete $object): array
    {
        return [];
    }
}
