<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\ContactsType;
use App\Repository\ContactsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
#[Route('/contacts')]
class ContactsController extends AbstractController
{
    #[Route('/', name: 'contacts_index', methods: ['GET'])]
    public function index(ContactsRepository $contactsRepository): Response
    {
        return $this->render('contacts/index.html.twig', [
            'contacts' => $contactsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'contacts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contacts();
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contacts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contacts/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'contacts_show', methods: ['GET'])]
    public function show(Contacts $contact): Response
    {
        return $this->render('contacts/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{id}/edit', name: 'contacts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contacts $contact, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('contacts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contacts/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'contacts_delete', methods: ['POST'])]
    public function delete(Request $request, Contacts $contact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contacts_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/list/{page<\d+>}', name:'contacts_index')]
    public function getItemsByPage($page = 1, ContactsRepository $contactsRepository)
    {
        $query = $contactsRepository    ->createQueryBuilder('i')
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

        return $this->render('contacts/index.html.twig', [
                'contacts' => $paginator,
                'pageCount' => $pageCount
            ]);
    }
}
