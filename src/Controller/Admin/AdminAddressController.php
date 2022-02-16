<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminAddressController extends AbstractController
{
    /**
     * @Route("/admin/address/liste", name="app_admin_adminAddress_list")
     */
    public function list(AddressRepository $repository): Response
    {
        $addresses = $repository->findAll();
        

        return $this->render('Admin/AdminAddress/list.html.twig', [
            'addresses' => $addresses,
        ]);
    }

    /**
     * @Route("/admin/address/creer", name="app_admin_adminAddress_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this
            ->createForm(AddressType::class)
            ->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminAddress_list');
        }

        return $this->render('Admin/AdminAddress/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/address/modifier/{id}", name="app_admin_adminAddress_update")
     */
    public function update(Address $address, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminAddress_list');
        }

        return $this->render('Admin/AdminAddress/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/address/supprimer/{id}", name="app_admin_adminAddress_delete")
     */
    public function delete(Address $address, EntityManagerInterface $manager): Response
    {
        $manager->remove($address);
        $manager->flush();

        return $this->redirectToRoute('app_admin_adminAddress_list');
    }
}
