<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Publisher;
use App\Form\PublisherType;
use App\Repository\PublisherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminPublisherController extends AbstractController
{
    /**
     * @Route("/admin/editeurs", name="app_admin_adminPublisher_list")
     */
    public function list(PublisherRepository $repository): Response
    {
        $publishers = $repository->findAll();
        

        return $this->render('Admin/AdminPublisher/list.html.twig', [
            'publishers' => $publishers,
        ]);
    }

    /**
     * @Route("/admin/editeurs/creer", name="app_admin_adminPublisher_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this
            ->createForm(PublisherType::class)
            ->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminPublisher_list');
        }

        return $this->render('Admin/AdminPublisher/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/editeurs/modifier/{id}", name="app_admin_adminPublisher_update")
     */
    public function update(Publisher $publisher, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(PublisherType::class, $publisher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();

            return $this->redirectToRoute('app_admin_adminPublisher_list');
        }

        return $this->render('Admin/AdminPublisher/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/editeurs/supprimer/{id}", name="app_admin_adminPublisher_delete")
     */
    public function delete(Publisher $publisher, EntityManagerInterface $manager): Response
    {
        $manager->remove($publisher);
        $manager->flush();

        return $this->redirectToRoute('app_admin_adminPublisher_list');
    }
}
