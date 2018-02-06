<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Type\ShowType;
use AppBundle\Entity\Show;

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
    public function createAction(Request $request) {

        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);

        $form->handleRequest($request);

        if($form->isValid()) {

            $generatedFileName = time().'_'.$show->getCategory()->getName().'.'.$show->getMainPicture()->guessClientExtension();
            $path = $this->getParameter('kernel.project_dir').'web'.$this->getParameter('upload_directory_file');

            $show->getMainPicture()->move($path, $generatedFileName);
            $show->setMainPicture($generatedFileName);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($show);
            $em->flush();
        }


        $this->addFlash('success', 'You successfully added a new show !');
        
        return $this->render('show/create.html.twig', ['showForm' => $form->createView()]);
    }

    public function categoriesAction() {
        
        return $this->render('_includes/categories.html.twig', [
            'categories' => ['Web Design', 'HTML', "Freebies", "Test", "ok", "ok"]
        ]);
    }
}