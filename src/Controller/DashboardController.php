<?php

namespace App\Controller;

use App\Service\UserService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
      private UserService $userService
    ){
    }

    #[Route('/admin/film', name: 'admin_film')]
    public function film(): Response
    {
        $admin = false;
        $user = $this->getUser();
        $userNow = $this->userService->getById($user->getUserIdentifier());
        $roles = $userNow->getRoles();
        foreach ($roles as $role) {
            if ($role == "ADMIN") {
                $admin = true;
                break;
            }
        }
        if (!$admin) {
            return $this->redirectToRoute('app_welcome');
        }
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(FilmCrudController::class)->generateUrl());
    }

    #[Route('/admin/user', name: 'admin_user')]
    public function index(): Response
    {
        $admin = false;
        $user = $this->getUser();
        $userNow = $this->userService->getById($user->getUserIdentifier());
        $roles = $userNow->getRoles();
        foreach ($roles as $role) {
            if ($role == "ADMIN") {
                $admin = true;
                break;
            }
        }
        if (!$admin) {
            return $this->redirectToRoute('app_welcome');
        }
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
            ->setTitle('Sofa Critics');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
