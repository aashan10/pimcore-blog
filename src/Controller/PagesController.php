<?php

namespace App\Controller;
use Pimcore\Document\Renderer\DocumentRenderer;
use Pimcore\Model\DataObject\BlogCategory;
use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\Document;
use Symfony\Component\HttpFoundation\Request;
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


    public function footerCopyrightAction(): Response
    {
        return $this->render('includes/footer.html.twig');
    }

    public function renderStaticPageAction(): Response
    {
        return $this->render('pages/static-page.html.twig');
    }

    public function renderPostRenderlet(Request $request)
    {
        $id = $request->get('id');
        $type = $request->get('type');

        if ($type === 'object') {
            $object = BlogPost::getById($id);
            if ($object instanceof BlogPost) {
                return $this->render('includes/post-renderlet.html.twig',[
                    'editmode' => $this->editmode,
                    'post' => $object
                ]);
            }
        }
        throw new \Exception('This renderlet only supports Blog Post objects!');
    }

}
