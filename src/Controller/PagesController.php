<?php

namespace App\Controller;
use Pimcore\Model\DataObject\BlogCategory;
use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\Document;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends BlogController
{

    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function homePageAction(): Response
    {
        $posts = new BlogPost\Listing();
        $posts->setOrderKey('published');
        $posts->setOrder('desc');
        $posts->setLimit(10);

        return $this->render('pages/home.html.twig', [
            'posts' => $posts->load()
        ]);
    }


    #[Route('/kategorie/{slug}', name: 'category_view', methods: ['GET'])]
    public function blogCategoryViewAction(string $slug): Response
    {
        $categories = BlogCategory::getBySlug($slug);
        $category = $categories->load();



        if ($categories->count() < 1 || !$category[0] instanceof BlogCategory) {
            throw $this->createNotFoundException();
        }

        $category = $category[0];

        $def = $category->getClass()->getFieldDefinition("blogs");
        $refKey = $def->getOwnerFieldName();
        $refId = $def->getOwnerClassId();
        $relations = $category->getRelationData($refKey, false, $refId);
        $ids = array_map(function($relation) {
            return $relation['id'];
        }, $relations);

        $posts = new BlogPost\Listing();
        $posts->setCondition('id IN (' . implode(',', $ids) . ')');


        return $this->render('pages/category/view.html.twig', [
            'category' => $category,
            'posts' => $posts->load()
        ]);
    }


    #[Route('/{slug}', name: 'blog_view', methods: ['GET'])]
    public function blogPostViewAction($slug): Response
    {
        // Handle documents with conflicting routes
        $document = Document::getByPath('/' . $slug);
        if ($document instanceof Document) {
            return new Response($this->renderer->render($document), 200);
        }

        // Handle blog posts
        $post = BlogPost::getBySlug($slug);
        if ($post->count() < 1) {
            throw $this->createNotFoundException();
        }

        $post = $post->load()[0];
        if (!$post instanceof BlogPost || !$post->getPublished()) {
            throw $this->createNotFoundException();
        }

        return $this->render('pages/blog/view.html.twig', [
            'post' => $post
        ]);
    }

    public function footerCopyrightAction(): Response
    {
        return $this->render('includes/footer.html.twig');
    }

}
