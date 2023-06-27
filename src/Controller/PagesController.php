<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends BlogController
{

    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function homePageAction(): Response
    {
        return $this->render('pages/home.html.twig');
    }


    #[Route('/kategorien/{slug}', name: 'category_view', methods: ['GET'])]
    public function blogCategoryViewAction(string $slug): Response
    {
        return $this->render('pages/category/view.html.twig');
    }


    #[Route('/{slug}', name: 'blog_view', methods: ['GET'])]
    public function blogPostViewAction(): Response
    {
        return $this->render('pages/blog/view.html.twig');
    }

    public function footerCopyrightAction(): Response
    {
        return $this->render('includes/footer.html.twig');
    }

}
