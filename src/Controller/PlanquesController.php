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

            return $this->redirectToRoute('planques_index', [], Response::HTTP_SEE_OTHER);
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

            return $this->redirectToRoute('planques_index', [], Response::HTTP_SEE_OTHER);
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

        return $this->redirectToRoute('planques_index', [], Response::HTTP_SEE_OTHER);
    }
}
