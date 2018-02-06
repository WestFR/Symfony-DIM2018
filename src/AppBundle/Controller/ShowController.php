<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\File\FileUploader;
use AppBundle\Type\ShowType;

use AppBundle\Entity\Show;
use AppBundle\Entity\Category;

/**
 * @Route(name="show_")
 */
class ShowController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function listAction()
    {
        return $this->render('show/list.html.twig');
    }

    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request, FileUploader $fileUploader) {

        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);

        $form->handleRequest($request);

        if($form->isValid()) {

            $generatedFileName = $fileUploader->upload($show->getMainPicture(), $show->getCategory()->getName());

            $show->setMainPicture($generatedFileName);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($show);
            $em->flush();

            $this->addFlash('success', 'You successfully added a new show !');
            return $this->redirectToRoute('show_list');
        }
        
        return $this->render('show/create.html.twig', ['showForm' => $form->createView()]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateAction(Request $request, Show $form, FileUploader $fileUploader) {

        $form = $this->createForm(ShowType::class, $form);

        $form->handleRequest($request);

        if($form->isValid()) {

            $generatedFileName = $fileUploader->upload($form->getMainPicture(), $form->getCategory()->getName());

            $form->setMainPicture($generatedFileName);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($form);
            $em->flush();

            $this->addFlash('success', 'You successfully updated the show !', ['validation_groups' => ['update']]);
            return $this->redirectToRoute('show_list');
        }

        return $this->render('show/create.html.twig', ['showForm' => $form->createView()]);
    }

    public function categoriesAction() {
        
        return $this->render('_includes/categories.html.twig', [
            'categories' => ['Web Design', 'HTML', "Freebies", "Test", "ok", "ok"]
        ]);
    }
}