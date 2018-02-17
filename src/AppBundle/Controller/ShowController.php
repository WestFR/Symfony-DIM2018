<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\HttpNotFoundException;

use AppBundle\File\FileUploader;

use AppBundle\Type\SearchType;
use AppBundle\Type\ShowType;

use AppBundle\ShowFinder\ShowFinder;

use AppBundle\Entity\Show;

/**
 * @Route(name="show_")
 */
class ShowController extends Controller
{
    // OLD INJECTION OF THIS VIEW AND FORM IN SHOW/BASE.BLADE.PHP
    /*public function searchAction(Request $request)
    {
        $form = $this->createForm(SearchType::class);

        return $this->render('_includes/search.html.twig', [
                'showForm' => $form->createView()
        ]);
    }*/

    /**
     * @Route("/", name="search")
     * @Method({"POST"})
     */
    public function searchAction(Request $request)
    {
        $request->getSession()->set('query_search_shows', $request->request->get('query'));

        return $this->redirectToRoute('show_list');
    }

    // OLD RESEARCH ROUTE
    /**
     * @Route("/", name="research")
     */
    /*public function researchAction(Request $request)
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
    }*/

    /**
     * @Route("/", name="list")
     */
    public function listAction(Request $request, ShowFinder $showFinder)
    {
        $showRepository = $this->getDoctrine()->getRepository(Show::class);
        $session = $request->getSession();

        if($session->has('query_search_shows')) {
            $show = $showFinder->findByName($session->get('query_search_shows'));
            
            $showLocal = $show['BDD_LOCAL'];
            $showOMDB = $show['OMDB_API'];
            $session->remove('query_search_shows');

            return $this->render('show/list.html.twig',['showLocal' => $showLocal, 'showOMDB' => $showOMDB]);
        }
        else {
            $shows = $showRepository->findAll();
            $session->remove('query_search_shows');
            return $this->render('show/list.html.twig',['showLocal' => $shows]);
        }

        /*$shows = $this->getDoctrine()->getRepository(Show::class)->findAll();*/

        /*return $this->render('show/list.html.twig', [
            'shows' => $shows,
        ]);*/
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
    public function deleteAction(Request $request, CsrfTokenManagerInterface $csrfTokenManager) {

        $doctrine = $this->getDoctrine();
        $showID = $request->request->get('show_id');
        

        if(!$show = $doctrine->getRepository(Show::class)->findOneById($showID)) {
            throw  new NotFoundException(sprintf('There is no show with the id %d', $showID));
        }

        $csrfToken = new CsrfToken('delete_show', $request->request->get('_csrf_token'));

        if($csrfTokenManager->isTokenValid($csrfToken)) {
            $doctrine->getManager()->remove($show);
            $doctrine->getManager()->flush();

            $this->addFlash('success', 'The show have been successfully deleted.');
        } else {
            $this->addFlash('danger', 'Then csrf token is not valid. The deletion was not completed.');
        }

        return $this->redirectToRoute('show_list'); 
    }


}