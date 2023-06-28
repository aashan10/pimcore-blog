<?php

namespace App\Extensions;

use App\Website\LinkGenerator\BlogCategoryLinkGenerator;
use Pimcore\Model\DataObject\BlogCategory;
use Pimcore\Model\Document;
use Pimcore\Navigation\Container;
use Twig\Extension\AbstractExtension;
use Pimcore\Twig\Extension\Templating\Navigation;

class NavigationExtension extends AbstractExtension
{

    public function __construct(
        protected Navigation                $navigationHelper,
        protected BlogCategoryLinkGenerator $linkGenerator
    )
    {
    }

    public function getFunctions(): array
    {
        return [
            new \Twig\TwigFunction('blog_navigation_generator', [$this, 'getNavigation'], ['is_safe' => ['html']]),
        ];
    }

    public function getNavigation(Document $document, Document $startNode): Container
    {
        $categoryLink = new \Pimcore\Navigation\Page\Document([
            'label' => 'Categories',
            'id' => 'object-' . 0,
            'uri' => '#',
        ]);

        $listing = BlogCategory::getList();
        $listing->load();

        foreach ($listing as $category) {
            $link = $this->linkGenerator->generate($category);
            $uri = new \Pimcore\Navigation\Page\Document([
                'label' => $category->getTitle(),
                'id' => 'object-' . $category->getId(),
                'uri' => $link,
            ]);
            $categoryLink->addPage($uri);
        }



        $nav =  $this->navigationHelper->build([
            'active' => $document,
            'root' => $startNode,
        ]);

        $nav->addPage($categoryLink);

        return $nav;

    }


}
