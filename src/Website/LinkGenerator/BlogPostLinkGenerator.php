<?php

namespace App\Website\LinkGenerator;

use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogPostLinkGenerator implements LinkGeneratorInterface
{

    public function generate(object $object, array $params = []): string
    {
        if ($object instanceof BlogPost && $object->getPublished()) {
            return '/' . $object->getSlug();
        }
        throw new NotFoundHttpException();
    }
}
