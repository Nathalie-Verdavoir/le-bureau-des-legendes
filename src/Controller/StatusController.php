<?php

namespace App\Controller;

use App\Entity\Status;
use App\Form\StatusType;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
#[Route('/status')]
class StatusController extends AbstractController
{
    #[Route('/', name: 'status_index', methods: ['GET'])]
    public function index(StatusRepository $statusRepository): Response
    {
        return $this->render('status/index.html.twig', [
            'statuses' => $statusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'status_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($status);
            $entityManager->flush();

            return $this->redirectToRoute('status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('status/new.html.twig', [
            'status' => $status,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'status_show', methods: ['GET'])]
    public function show(Status $status): Response
    {
        return $this->render('status/show.html.twig', [
            'status' => $status,
        ]);
    }

    #[Route('/{id}/edit', name: 'status_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Status $status, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('status/edit.html.twig', [
            'status' => $status,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'status_delete', methods: ['POST'])]
    public function delete(Request $request, Status $status, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$status->getId(), $request->request->get('_token'))) {
            $entityManager->remove($status);
            $entityManager->flush();
        }

        return $this->redirectToRoute('status_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/list/{page<\d+>}', name:'status_list')]
    public function getItemsByPage($page = 1, StatusRepository $statusRepository)
    {
        $query = $statusRepository  ->createQueryBuilder('i')
                                    ->orderBy('i.etat', 'ASC')
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

        return $this->render('status/index.html.twig', [
                'statuses' => $paginator,
                'pageCount' => $pageCount
            ]);
        // return stuff..
    // return [$userList, $totalItems, $pageCount];
    }
}
