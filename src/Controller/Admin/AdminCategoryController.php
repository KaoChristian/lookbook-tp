<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/admin/category/liste", name="app_admin_adminCategory_list")
     */
    public function list(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();
        

        return $this->render('Admin/AdminCategory/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin/category/creer", name="app_admin_adminCategory_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this
            ->createForm(CategoryType::class)
            ->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminCategory_list');
        }

        return $this->render('Admin/AdminCategory/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/category/modifier/{id}", name="app_admin_adminCategory_update")
     */
    public function update(Category $category, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminCategory_list');
        }

        return $this->render('Admin/AdminCategory/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/category/supprimer/{id}", name="app_admin_adminCategory_delete")
     */
    public function delete(Category $category, EntityManagerInterface $manager): Response
    {
        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('app_admin_adminCategory_list');
    }
}
