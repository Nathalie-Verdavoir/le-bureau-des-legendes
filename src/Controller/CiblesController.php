<?php

namespace App\Controller;

use App\Entity\Cibles;
use App\Form\CiblesType;
use App\Repository\CiblesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
#[Route('/cibles')]
class CiblesController extends AbstractController
{
    #[Route('/', name: 'cibles_index', methods: ['GET'])]
    public function index(CiblesRepository $ciblesRepository): Response
    {
        return $this->render('cibles/index.html.twig', [
            'cibles' => $ciblesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'cibles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cible = new Cibles();
        $form = $this->createForm(CiblesType::class, $cible);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cible);
            $entityManager->flush();

            return $this->redirectToRoute('cibles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cibles/new.html.twig', [
            'cible' => $cible,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'cibles_show', methods: ['GET'])]
    public function show(Cibles $cible): Response
    {
        return $this->render('cibles/show.html.twig', [
            'cible' => $cible,
        ]);
    }

    #[Route('/{id}/edit', name: 'cibles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cibles $cible, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CiblesType::class, $cible);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('cibles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cibles/edit.html.twig', [
            'cible' => $cible,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'cibles_delete', methods: ['POST'])]
    public function delete(Request $request, Cibles $cible, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cible->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cible);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cibles_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/list/{page<\d+>}', name:'cibles_index')]
    public function getItemsByPage($page = 1, CiblesRepository $ciblesRepository)
    {
        $query = $ciblesRepository  ->createQueryBuilder('i')
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

        return $this->render('cibles/index.html.twig', [
                'cibles' => $paginator,
                'pageCount' => $pageCount
            ]);
    }

    
}
