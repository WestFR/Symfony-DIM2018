<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Type\CategoryType;
use AppBundle\Entity\Category;

/**
 * @Route("category", name="category_")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request) {

        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isValid()) {
            
            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'You successfully added a new category !');

            return $this->redirectToRoute('show_list');
        }

    
        
        return $this->render('category/create.html.twig', ['showForm' => $form->createView()]);
    }

    /*public function categoriesAction() {
        
        return $this->render('_includes/categories.html.twig', [
            'categories' => ['Web Design', 'HTML', "Freebies", "Test", "ok", "ok"]
        ]);
    }*/
}