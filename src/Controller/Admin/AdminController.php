<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted('ROLE_ADMIN')
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin_admin_dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render("Admin/Admin/dashboard.html.twig");
    }

    
}
