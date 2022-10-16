<?php

namespace App\Controller;

use App\Entity\TypeDeMissions;
use App\Form\TypeDeMissionsType;
use App\Repository\TypeDeMissionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
#[Route('/type_de_missions')]
class TypeDeMissionsController extends AbstractController
{
    #[Route('/', name: 'type_de_missions_index', methods: ['GET'])]
    public function index(TypeDeMissionsRepository $typeDeMissionsRepository): Response
    {
        return $this->render('type_de_missions/index.html.twig', [
            'type_de_missions' => $typeDeMissionsRepository->findAll(),
        ]);
    }

    #[Route('/list/{page<\d+>}', name:'type_de_missions_list')]
    public function getItemsByPage(TypeDeMissionsRepository $typeDeMissionsRepository,int $page = 1): Response
    {
        $query = $typeDeMissionsRepository  ->createQueryBuilder('i')
                                            ->orderBy('i.nom', 'ASC')
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

        return $this->render('type_de_missions/index.html.twig', [
                'type_de_missions' => $paginator,
                'pageCount' => $pageCount
            ]);
    }

    #[Route('/new', name: 'type_de_missions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeDeMission = new TypeDeMissions();
        $form = $this->createForm(TypeDeMissionsType::class, $typeDeMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeDeMission);
            $entityManager->flush();

            return $this->redirectToRoute('type_de_missions_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_de_missions/new.html.twig', [
            'type_de_mission' => $typeDeMission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_de_missions_show', methods: ['GET'])]
    public function show(TypeDeMissions $typeDeMission): Response
    {
        return $this->render('type_de_missions/show.html.twig', [
            'type_de_mission' => $typeDeMission,
        ]);
    }

    #[Route('/{id}/edit', name: 'type_de_missions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeDeMissions $typeDeMission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeDeMissionsType::class, $typeDeMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('type_de_missions_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_de_missions/edit.html.twig', [
            'type_de_mission' => $typeDeMission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_de_missions_delete', methods: ['POST'])]
    public function delete(Request $request, TypeDeMissions $typeDeMission, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeDeMission->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeDeMission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_de_missions_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
    }
}
