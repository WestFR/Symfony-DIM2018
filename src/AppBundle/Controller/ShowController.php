<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\HttpNotFoundException;

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
     * @Route("/", name="research")
     */
    public function researchAction(Request $request)
    {
        $nameShow = $request->request->get("search")["name"].'%';
 
        if($nameShow != '')
        {
            $shows = $this->getDoctrine()->getRepository(Show::class)->createQueryBuilder('show')
                    ->where('show.name LIKE :name')
                    ->setParameter('name', $nameShow)
                    ->getQuery()
                    ->getResult();
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
     * @Route("/show/{id}", name="show")
     */
    public function showAction(Request $request)
    {
        $showID = $request->get('id');

        $show = $this->getDoctrine()->getRepository(Show::class)->findOneById($showID);

        return $this->render('show/show.html.twig', [
            'show' => $show,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request, FileUploader $fileUploader) {

        $show = new Show();
        $form = $this->createForm(ShowType::class, $show, ['validation_groups' => 'create']);

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

    /**
     * @Route("/delete", name="delete")
     * @Method({"POST"})
     */
    public function deleteAction(Request $request) {

        $doctrine = $this->getDoctrine();
        $showID = $request->request->get('show_id');
        

        if(!$show = $doctrine->getRepository(Show::class)->findOneById($showID)) {
            throw  new NotFoundException(sprintf('There is no show with the id %d', $showID));
        }

        $doctrine->getManager()->remove($show);
        $doctrine->getManager()->flush();

        $this->addFlash('success', 'The show have been successfully deleted.');
        return $this->redirectToRoute('show_list'); 
    }


}