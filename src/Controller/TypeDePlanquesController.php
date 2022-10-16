<?php

namespace App\Controller;

use App\Entity\TypeDePlanques;
use App\Form\TypeDePlanquesType;
use App\Repository\TypeDePlanquesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
#[Route('/type_de_planques')]
class TypeDePlanquesController extends AbstractController
{
    #[Route('/', name: 'type_de_planques_index', methods: ['GET'])]
    public function index(TypeDePlanquesRepository $typeDePlanquesRepository): Response
    {
        return $this->render('type_de_planques/index.html.twig', [
            'type_de_planques' => $typeDePlanquesRepository->findAll(),
        ]);
    }

    #[Route('/list/{page<\d+>}', name:'type_de_planques_index')]
    public function getItemsByPage(TypeDePlanquesRepository $typeDePlanquesRepository,int $page = 1 ): Response
    {
        $query = $typeDePlanquesRepository  ->createQueryBuilder('i')
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

        return $this->render('type_de_planques/index.html.twig', [
                'type_de_planques' => $paginator,
                'pageCount' => $pageCount
            ]);
    }

    #[Route('/new', name: 'type_de_planques_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeDePlanque = new TypeDePlanques();
        $form = $this->createForm(TypeDePlanquesType::class, $typeDePlanque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeDePlanque);
            $entityManager->flush();

            return $this->redirectToRoute('type_de_planques_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_de_planques/new.html.twig', [
            'type_de_planque' => $typeDePlanque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_de_planques_show', methods: ['GET'])]
    public function show(TypeDePlanques $typeDePlanque): Response
    {
        return $this->render('type_de_planques/show.html.twig', [
            'type_de_planque' => $typeDePlanque,
        ]);
    }

    #[Route('/{id}/edit', name: 'type_de_planques_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeDePlanques $typeDePlanque, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeDePlanquesType::class, $typeDePlanque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('type_de_planques_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_de_planques/edit.html.twig', [
            'type_de_planque' => $typeDePlanque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_de_planques_delete', methods: ['POST'])]
    public function delete(Request $request, TypeDePlanques $typeDePlanque, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeDePlanque->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeDePlanque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_de_planques_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
    }
}
