<?php

namespace App\Controller;

use App\Entity\Agents;
use App\Form\AgentsType;
use App\Repository\AgentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
#[Route('/agents')]
class AgentsController extends AbstractController
{
    #[Route('/', name: 'agents_index', methods: ['GET'])]
    public function index(AgentsRepository $agentsRepository): Response
    {
        return $this->render('agents/index.html.twig', [
            'agents' => $agentsRepository->findAll(),
        ]);
    }

    #[Route('/list/{page<\d+>}', name:'agents_index')]
    public function getItemsByPage( AgentsRepository $agentsRepository,int $page = 1): Response
    {
        $query = $agentsRepository  ->createQueryBuilder('i')
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

        return $this->render('agents/index.html.twig', [
                'agents' => $paginator,
                'pageCount' => $pageCount
            ]);
    }

    #[Route('/new', name: 'agents_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $agent = new Agents();
        $form = $this->createForm(AgentsType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($agent);
            $entityManager->flush();

            return $this->redirectToRoute('agents_index',array(
            'page' => $page = 1,
            ), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agents/new.html.twig', [
            'agent' => $agent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'agents_show', methods: ['GET'])]
    public function show(Agents $agent): Response
    {
        return $this->render('agents/show.html.twig', [
            'agent' => $agent,
        ]);
    }

    #[Route('/{id}/edit', name: 'agents_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agents $agent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AgentsType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('agents_index',array(
            'page' => 1,
            ), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agents/edit.html.twig', [
            'agent' => $agent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'agents_delete', methods: ['POST'])]
    public function delete(Request $request, Agents $agent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agent->getId(), $request->request->get('_token'))) {
            $entityManager->remove($agent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agents_index',array(
            'page' => 1,
            ), Response::HTTP_SEE_OTHER);
    }
}
