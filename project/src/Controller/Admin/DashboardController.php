<?php

namespace App\Controller\Admin;

use App\Controller\EntrepriseController;
use App\Entity\Comment;
use App\Entity\Devis;
use App\Entity\Entreprise;
use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $dminUrlGenerator)
    {
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->dminUrlGenerator
            ->setController(EntrepriseCrudController::class)
            ->generateUrl();

        return $this->redirect($url);


    
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Weeetruck');
    }

    public function configureMenuItems(): iterable
    {
       

        yield MenuItem::subMenu('Entreprises', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Création Entreprise', 'fas fa-plus', Entreprise::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste Entreprises', 'fas fa-eye', Entreprise::class)->setAction(Crud::PAGE_INDEX),
        ]);
        yield MenuItem::subMenu('Employés', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Création Employé', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste Employés', 'fas fa-eye', User::class)->setAction(Crud::PAGE_INDEX),
        ]);

        yield MenuItem::linkToCrud('Devis', 'fas fa-eye', Devis::class)->setAction(Crud::PAGE_INDEX);
        yield  MenuItem::linkToCrud('Tickets', 'fas fa-eye', Ticket::class)->setAction(Crud::PAGE_INDEX);

        yield  MenuItem::linkToCrud('Commentaires', 'fas fa-eye', Comment::class)->setAction(Crud::PAGE_INDEX);
    }
}
