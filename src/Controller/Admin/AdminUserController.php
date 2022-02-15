<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @IsGranted('ROLE_ADMIN')
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user/liste", name="app_admin_adminUser_list")
     */
    public function list(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        return $this->render('Admin/AdminUser/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/creer", name="app_admin_adminUser_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this
            ->createForm(UserType::class)
            ->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminUser_list');
        }

        return $this->render('Admin/AdminUser/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
