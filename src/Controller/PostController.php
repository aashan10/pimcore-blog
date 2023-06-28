<?php

namespace App\Controller;

use Pimcore\Model\DataObject\BlogPost;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends BlogController
{
    #[Route('/search', name: 'search', methods: ['POST'])]
    public function searchPosts(Request $request): Response
    {
        $query = $request->get('query');
        $posts = new BlogPost\Listing();
        $posts->setCondition('title LIKE ? OR content LIKE ?', ['%' . $query . '%', '%' . $query . '%']);
        $posts->setOrderKey('published');
        $posts->setOrder('desc');
        $posts->setLimit(10);

        return $this->render('pages/search.html.twig', [
            'posts' => $posts->load(),
            'query' => $query,
            'count' => $posts->count(),
        ]);

    }

    #[Route('/blog/{slug}', name: 'blog_view', methods: ['GET'])]
    public function blogPostViewAction($slug): Response
    {
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


}
