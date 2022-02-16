<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminAuthorController extends AbstractController
{
    /**
     * @Route("/admin/author/liste", name="app_admin_adminAuthor_list")
     */
    public function list(AuthorRepository $repository): Response
    {
        $authors = $repository->findAll();
        

        return $this->render('Admin/AdminAuthor/list.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/admin/author/creer", name="app_admin_adminAuthor_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this
            ->createForm(AuthorType::class)
            ->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminAuthor_list');
        }

        return $this->render('Admin/AdminAuthor/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/author/modifier/{id}", name="app_admin_adminAuthor_update")
     */
    public function update(Author $author, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminAuthor_list');
        }

        return $this->render('Admin/AdminAuthor/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/author/supprimer/{id}", name="app_admin_adminAuthor_delete")
     */
    public function delete(Author $author, EntityManagerInterface $manager): Response
    {
        $manager->remove($author);
        $manager->flush();

        return $this->redirectToRoute('app_admin_adminAuthor_list');
    }
}
