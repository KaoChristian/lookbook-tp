<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Form\SubscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

            return $this->redirectToRoute("app_front_user_connexion");
        }

        return $this->render("Front/User/subscription.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
