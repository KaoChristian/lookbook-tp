<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\Author;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="app_front_front_home")
     */
    public function home(): Response
    {
        return $this->render('Front/Front/home.html.twig');
    }

    /**
     * @Route("/auteur", name="app_front_author")
     */
    public function authorList(AuthorRepository $repository): Response
    {
        $authors = $repository->findAll();

        return $this->render("Front/Front/auteur.html.twig", [
            "authors" => $authors
        ]);
    }

    /**
     * @Route("/auteur/{id}", name="app_front_author_show")
     */
    public function authorShow(BookRepository $repository, Author $author, AuthorRepository $repo, int $id): Response
    {   

        $auteur = $author->getName();
        

        return $this->render("Front/Front/auteur-show.html.twig", [
            "books" => $repository->findTwentyFiveBooks($auteur),
            "author" => $repo->find($id),
        ]);
    }
}
