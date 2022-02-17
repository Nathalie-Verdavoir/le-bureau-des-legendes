<?php

namespace App\Controller\Admin;

use App\Entity\Agents;
use App\Entity\Cibles;
use App\Entity\Contacts;
use App\Entity\Missions;
use App\Entity\NomDeCode;
use App\Entity\Pays;
use App\Entity\Planques;
use App\Entity\Specialites;
use App\Entity\Status;
use App\Entity\TypeDeMissions;
use App\Entity\TypeDePlanques;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{   #[Security("is_granted('ROLE_SUPER_ADMIN')", statusCode: 404)]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Le Bureau Des Legendes');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard - Users', 'fa fa-home');
        yield MenuItem::linkToCrud('Agents', 'fas fa-list', Agents::class);
        yield MenuItem::linkToCrud('Cibles', 'fas fa-list', Cibles::class);
        yield MenuItem::linkToCrud('Contacts', 'fas fa-list', Contacts::class);
        yield MenuItem::linkToCrud('Missions', 'fas fa-list', Missions::class);
        yield MenuItem::linkToCrud('NomDeCode', 'fas fa-list', NomDeCode::class);
        yield MenuItem::linkToCrud('Pays', 'fas fa-list', Pays::class);
        yield MenuItem::linkToCrud('Planques', 'fas fa-list', Planques::class);
        yield MenuItem::linkToCrud('Specialites', 'fas fa-list', Specialites::class);
        yield MenuItem::linkToCrud('Status', 'fas fa-list', Status::class);
        yield MenuItem::linkToCrud('TypeDeMissions', 'fas fa-list', TypeDeMissions::class);
        yield MenuItem::linkToCrud('TypeDePlanques', 'fas fa-list', TypeDePlanques::class);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin.css');
    }
}
