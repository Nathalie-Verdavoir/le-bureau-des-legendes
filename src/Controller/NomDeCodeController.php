<?php

namespace App\Controller;

use App\Entity\NomDeCode;
use App\Form\NomDeCodeType;
use App\Repository\NomDeCodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
#[Route('/nomdecode')]
class NomDeCodeController extends AbstractController
{
    #[Route('/', name: 'nom_de_code_index', methods: ['GET'])]
    public function index(NomDeCodeRepository $nomDeCodeRepository): Response
    {
        return $this->render('nom_de_code/index.html.twig', [
            'nom_de_codes' => $nomDeCodeRepository->findAll(),
        ]);
    }

    #[Route('/list/{page<\d+>}', name:'nom_de_code_index')]
    public function getItemsByPage(NomDeCodeRepository $nomDeCodeRepository,int $page = 1)
    {
        $query = $nomDeCodeRepository   ->createQueryBuilder('i')
                                        ->orderBy('i.code', 'ASC')
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

        return $this->render('nom_de_code/index.html.twig', [
                'nom_de_codes' => $paginator,
                'pageCount' => $pageCount
            ]);
    }
    
    #[Route('/new', name: 'nom_de_code_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nomDeCode = new NomDeCode();
        $form = $this->createForm(NomDeCodeType::class, $nomDeCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nomDeCode);
            $entityManager->flush();

            return $this->redirectToRoute('nom_de_code_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nom_de_code/new.html.twig', [
            'nom_de_code' => $nomDeCode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'nom_de_code_show', methods: ['GET'])]
    public function show(NomDeCode $nomDeCode): Response
    {
        return $this->render('nom_de_code/show.html.twig', [
            'nom_de_code' => $nomDeCode,
        ]);
    }

    #[Route('/{id}/edit', name: 'nom_de_code_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NomDeCode $nomDeCode, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NomDeCodeType::class, $nomDeCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('nom_de_code_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nom_de_code/edit.html.twig', [
            'nom_de_code' => $nomDeCode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'nom_de_code_delete', methods: ['POST'])]
    public function delete(Request $request, NomDeCode $nomDeCode, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nomDeCode->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nomDeCode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nom_de_code_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
    }

}
