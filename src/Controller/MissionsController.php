<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Form\MissionsType;
use App\Repository\MissionsRepository;
use App\Validator\CiblesAgents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Route('/missions')]
class MissionsController extends AbstractController
{
    #[Route('/', name: 'missions_index', methods: ['GET'])]
    public function index(MissionsRepository $missionsRepository): Response
    {
        return $this->render('missions/index.html.twig', [
            'missions' => $missionsRepository->findAll(),
        ]);
    }
    
    #[Route('/list/{page}', name:'missions_index')]
    public function getItemsByPage(MissionsRepository $missionsRepository,int $page = 1)
    {
        $query = $missionsRepository    ->createQueryBuilder('i')
                                        ->orderBy('i.titre', 'ASC')
                                        ->getQuery();

        //set page size
        $pageSize = '10';

        // load doctrine Paginator
        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);

        // you can get total items
        $totalItems = count($paginator);

        // get total pages
        $pageCount = ceil($totalItems / $pageSize);

        // now get one page's items:
        $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($page-1)) // set the offset
            ->setMaxResults($pageSize); // set the limit

        return $this->render('missions/index.html.twig', [
                'missions' => $paginator,
                'pageCount' => $pageCount
            ]);
    }
    #[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
    #[Route('/new', name: 'missions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    { 
        $mission = new Missions();
        $form = $this->createForm(MissionsType::class, $mission,[
           // 'validation_groups' => ['CiblesAgents','ContactsPays']
           // 'constraints' => new CiblesAgents(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mission);
            $entityManager->flush();
           
            return $this->redirectToRoute('missions_index',array(
                'page' => 1,
                ),  Response::HTTP_SEE_OTHER);
                
        }

        return $this->renderForm('missions/new.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'missions_show', methods: ['GET'])]
    public function show(Missions $mission): Response
    {
        return $this->render('missions/show.html.twig', [
            'mission' => $mission,
        ]);
    }

    #[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
    #[Route('/{id}/edit', name: 'missions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Missions $mission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionsType::class, $mission,[
            //'validation_groups' => ['CiblesAgents','ContactsPays']
           // 'constraints' => new CiblesAgents(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();

            return $this->redirectToRoute('missions_index',array(
                'page' => $page = 1,
                ), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('missions/edit.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
    #[Route('/{id}', name: 'missions_delete', methods: ['POST'])]
    public function delete(Request $request, Missions $mission, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mission->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mission);
            $entityManager->flush();
        }
        return $this->redirectToRoute('missions_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
    }

}
