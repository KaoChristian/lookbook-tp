<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted('ROLE_ADMIN')
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user/list", name="app_admin_adminUser_list")
     */
    public function list(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        return $this->render('Admin/AdminUser/list.html.twig', [
            'users' => $users,
        ]);
    }
}
