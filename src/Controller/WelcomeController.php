<?php
// src/Controller/WelcomeController.php
namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        $name = 'Nat';
        return $this->render('welcome.html.twig', [
            'name' => $name,
        ]);
    }
}