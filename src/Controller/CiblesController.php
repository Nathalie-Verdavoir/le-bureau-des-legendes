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
}
