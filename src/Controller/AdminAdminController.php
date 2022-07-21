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
        // Création d'un formulaire lié à la table User via ses paramètres lié à l'instance d'Article
        $form = $this->createForm(UserType::class, $user);
        // On donne la variable form une instance de Request pour que le formulaire puisse
        // récupérer les données et les traiter automatiquement
        $form->handleRequest($request);
        // Si le formulaire à été posté et que les données sont valides, on envoie sur la base de données
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
            // Utilisation de la méthode createView pour créer la view du formulaire
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/admin-delete/{id}", name="admin_admin_delete")
     */
    public function adminDelete($id, EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        if(!is_null($user))
        {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', "Vous avez bien supprimé l'admin ");
            return $this->redirectToRoute('admin_admin_list');
        }
        $this->addFlash('error', 'Admin introuvable');
        return $this->redirectToRoute('admin_admin_list');
    }

    /**
     * @Route("/admin/admin-update/{id}", name="admin_admin_update")
     */
    public function adminUpdate($id, EntityManagerInterface $entityManager, UserRepository $userRepository, Request $request, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = $userRepository->find($id);
        // Création d'un formulaire lié à la table User via ses paramètres lié à l'instance d'Article
        $form = $this->createForm(UserType::class, $user);
        // On donne la variable form une instance de Request pour que le formulaire puisse
        // récupérer les données et les traiter automatiquement
        $form->handleRequest($request);
        // Si le formulaire à été posté et que les données sont valides, on envoie sur la base de données
        if($form->isSubmitted() && $form->isValid()){

            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', "Vous avez bien modifié l'admin");

            return $this->redirectToRoute('admin_admin_list');
        }

        return $this->render('admin/admin-update.html.twig',[
            // Utilisation de la méthode createView pour créer la view du formulaire
            'form' => $form->createView()
        ]);
    }
}