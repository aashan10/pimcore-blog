<?php

namespace App\Controller;

use Pimcore\Model\DataObject\BlogCategory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends BlogController
{


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

        if (count($ids) > 0) {
            $posts->setCondition('id IN (' . implode(',', $ids) . ')');
        } else {
            $posts->setCondition('id = 0'); // Always results in false as pimcore object ids start with 1
        }


        return $this->render('pages/category/view.html.twig', [
            'category' => $category,
            'posts' => $posts->load()
        ]);
    }


}
