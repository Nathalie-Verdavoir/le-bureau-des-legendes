<?php

namespace App\Controller;

use App\Entity\Specialites;
use App\Form\SpecialitesType;
use App\Repository\SpecialitesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
#[Route('/specialites')]
class SpecialitesController extends AbstractController
{
    #[Route('/', name: 'specialites_index', methods: ['GET'])]
    public function index(SpecialitesRepository $specialitesRepository): Response
    {
        return $this->render('specialites/index.html.twig', [
            'specialites' => $specialitesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'specialites_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $specialite = new Specialites();
        $form = $this->createForm(SpecialitesType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($specialite);
            $entityManager->flush();

            return $this->redirectToRoute('specialites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('specialites/new.html.twig', [
            'specialite' => $specialite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'specialites_show', methods: ['GET'])]
    public function show(Specialites $specialite): Response
    {
        return $this->render('specialites/show.html.twig', [
            'specialite' => $specialite,
        ]);
    }

    #[Route('/{id}/edit', name: 'specialites_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Specialites $specialite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpecialitesType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('specialites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('specialites/edit.html.twig', [
            'specialite' => $specialite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'specialites_delete', methods: ['POST'])]
    public function delete(Request $request, Specialites $specialite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($specialite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('specialites_index', [], Response::HTTP_SEE_OTHER);
    }
}
