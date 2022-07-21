<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdminController extends AbstractController
{
    /**
     * @Route("/admin/admins", name="admin_admin_list")
     */
    public function adminList(UserRepository $userRepository)
    {
        $admins = $userRepository->findAll();
        return $this->render('admin/admin-list.html.twig', [
            'admins' => $admins
        ]);
    }

    /**
     * @route("/admin/admin-insert/", name="admin_admin_insert")
     */
    public function adminInsert(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = new User();
        $user->setRoles(["ROLE_ADMIN"]);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', "Vous avez bien ajouté l'admin");

            return $this->redirectToRoute('admin_admin_list');
        }

        return $this->render('admin/admin-insert.html.twig',[
            'form' => $form->createView()
        ]);
    }
}