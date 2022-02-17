<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminBookController extends AbstractController
{
    /**
     * @Route("/admin/livres/liste", name="app_admin_adminBook_list")
     */
    public function list(BookRepository $repository): Response
    {
        $books = $repository->findAll();
        

        return $this->render('Admin/AdminBook/list.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/admin/livres/creer", name="app_admin_adminBook_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this
            ->createForm(BookType::class)
            ->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminBook_list');
        }

        return $this->render('Admin/AdminBook/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/livres/modifier/{id}", name="app_admin_adminBook_update")
     */
    public function update(Book $book, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminBook_list');
        }

        return $this->render('Admin/AdminBook/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/livres/supprimer/{id}", name="app_admin_adminBook_delete")
     */
    public function delete(Book $book, EntityManagerInterface $manager): Response
    {
        $manager->remove($book);
        $manager->flush();

        return $this->redirectToRoute('app_admin_adminBook_list');
    }
}
