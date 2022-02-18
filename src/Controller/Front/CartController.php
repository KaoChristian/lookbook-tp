<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\Book;
use App\Entity\Cart;
use App\Entity\User;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/mon-panier", name="app_front_cart_cart")
     */
    public function cart(UserRepository $user): Response
    {
        
        $cart = $user->getCart();

        return $this->render("Front/Front/cart.html.twig", [
            "cart" => $cart
        ]);
    }

    // /**
    //  * @Route("/ajouter-panier/{id}", name="app_front_cart_addToCart")
    //  */
    // public function addToCart(Book $book, UserRepository $repository): Response
    // {
    //     $user = $repository->getUser();
    // }
}
