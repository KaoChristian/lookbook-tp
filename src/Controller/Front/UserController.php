<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\Book;
use App\Form\BookType;
use App\Form\SubscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_front_user_subscription")
     */
    public function subscription(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $crypter): Response
    {
        $form = $this->createForm(SubscriptionType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            $user->setPassword($crypter->hashPassword(
                $user,
                $user->getPassword()
            ));

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("app_login");
        }

        return $this->render("Front/User/subscription.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    /**
     * @Route("/mon-profil", name="app_front_user_profile")
     */
    public function profile(): Response
    {
        $user = $this->getUser();

        if($user==null) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('Front/User/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    /**
     * @Route("/vendre-livre", name="app_front_user_createBook")
     */
    public function createBook(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form = $this
            ->createForm(BookType::class)
            ->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $manager->persist($book->setReseller($user));
            $manager->flush();

            return $this->redirectToRoute('app_front_user_profile');
        }

        return $this->render('Front/User/createBook.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    /**
     * @Route("/modifier-livre/{id}", name="app_front_user_updateBook")
     */
    public function updateBook(Book $book, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_front_user_profile');
        }

        return $this->render('Front/User/updateBook.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    /**
     * @Route("/supprimer-livre/{id}", name="app_front_user_deleteBook")
     */
    public function deleteBook(Book $book, EntityManagerInterface $manager): Response
    {
        $manager->remove($book);
        $manager->flush();

        return $this->redirectToRoute('app_front_user_profile');
    }
}
