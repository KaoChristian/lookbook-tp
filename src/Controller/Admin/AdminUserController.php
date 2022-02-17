<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/utilisateurs", name="app_admin_adminUser_list")
     */
    public function list(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        return $this->render('Admin/AdminUser/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/utilisateurs/creer", name="app_admin_adminUser_create")
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

    /**
     * @Route("/admin/utilisateurs/modifier/{id}", name="app_admin_adminUser_update")
     */
    public function update(User $user, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminUser_list');
        }

        return $this->render('Admin/AdminUser/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/utilisateurs/supprimer/{id}", name="app_admin_adminUser_delete")
     */
    public function delete(User $user, EntityManagerInterface $manager): Response
    {
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('app_admin_adminUser_list');
    }
}
