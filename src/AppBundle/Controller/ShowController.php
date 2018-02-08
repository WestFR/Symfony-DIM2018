<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\File\FileUploader;

use AppBundle\Type\SearchType;
use AppBundle\Type\ShowType;

use AppBundle\Entity\Show;

/**
 * @Route(name="show_")
 */
class ShowController extends Controller
{

    public function searchAction(Request $request)
    {
        $form = $this->createForm(SearchType::class);

        return $this->render('_includes/search.html.twig', [
                'showForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/search", name="research")
     */
    public function researchAction(Request $request)
    {
        $nameShow = $request->request->get("search")["name"];
        //dump($nameShow);die;
        //throw new NotFoundHttpException('!name '.$nameShow.'<');
 
        if($nameShow != '')
        {
            $shows = $this->getDoctrine()->getRepository(Show::class)->findBy(['name' => $nameShow]);
        }
        else {
            $shows = $this->getDoctrine()->getRepository(Show::class)->findAll();
        }
 
        return $this->render('show/list.html.twig', [
            'shows' => $shows, 
        ]);
    }

    /**
     * @Route("/", name="list")
     */
    public function listAction(Request $request)
    {
        $shows = $this->getDoctrine()->getRepository(Show::class)->findAll();

        return $this->render('show/list.html.twig', [
            'shows' => $shows,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request, FileUploader $fileUploader) {

        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $generatedFileName = $fileUploader->upload($show->getTmpPicture(), $show->getCategory()->getName());

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
    public function updateAction(Request $request, Show $show, FileUploader $fileUploader) {

        $form = $this->createForm(ShowType::class, $show, ['validation_groups'=> ['update']]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if($show->getTmpPicture() != null) {      
                $generatedFileName = $fileUploader->uploadReplace($show->getTmpPicture(), $show->getCategory()->getName(), $show->getMainPicture());  
                $show->setMainPicture($generatedFileName);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'You successfully updated the show !', ['validation_groups' => ['update']]);
            return $this->redirectToRoute('show_list');
        }

        return $this->render('show/create.html.twig', ['showForm' => $form->createView()]);
    }
}