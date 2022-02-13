<?php

namespace App\Controller;

use App\Entity\Planques;
use App\Form\PlanquesType;
use App\Repository\PlanquesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
#[Route('/planques')]
class PlanquesController extends AbstractController
{
    #[Route('/', name: 'planques_index', methods: ['GET'])]
    public function index(PlanquesRepository $planquesRepository): Response
    {
        return $this->render('planques/index.html.twig', [
            'planques' => $planquesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'planques_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $planque = new Planques();
        $form = $this->createForm(PlanquesType::class, $planque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($planque);
            $entityManager->flush();

            return $this->redirectToRoute('planques_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planques/new.html.twig', [
            'planque' => $planque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'planques_show', methods: ['GET'])]
    public function show(Planques $planque): Response
    {
        return $this->render('planques/show.html.twig', [
            'planque' => $planque,
        ]);
    }

    #[Route('/{id}/edit', name: 'planques_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Planques $planque, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanquesType::class, $planque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('planques_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planques/edit.html.twig', [
            'planque' => $planque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'planques_delete', methods: ['POST'])]
    public function delete(Request $request, Planques $planque, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planque->getId(), $request->request->get('_token'))) {
            $entityManager->remove($planque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('planques_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
    }

    #[Route('/list/{page<\d+>}', name:'planques_list')]
    public function getItemsByPage(PlanquesRepository $planquesRepository,int $page = 1)
    {
        $query = $planquesRepository    ->createQueryBuilder('i')
                                        ->orderBy('i.id', 'ASC')
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

        return $this->render('planques/index.html.twig', [
                'planques' => $paginator,
                'pageCount' => $pageCount
            ]);
        // return stuff..
    // return [$userList, $totalItems, $pageCount];
    }
}
