<?php

namespace App\Website\PreviewGenerator;

use App\Website\LinkGenerator\BlogPostLinkGenerator;
use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\DataObject\ClassDefinition\PreviewGeneratorInterface;
use Pimcore\Model\DataObject\Concrete;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogPostPreviewGenerator implements PreviewGeneratorInterface
{
    public function __construct(protected BlogPostLinkGenerator $linkGenerator)
    {
    }

    public function generatePreviewUrl(Concrete $object, array $params): string
    {
        if ($object->getPublished() && $object instanceof BlogPost) {
            return $this->linkGenerator->generate($object);
        }

        throw new NotFoundHttpException();
    }

    public function getPreviewConfig(Concrete $object): array
    {
        return [];
    }
}
