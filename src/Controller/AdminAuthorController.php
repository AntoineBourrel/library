<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdminAuthorController extends AbstractController
{
    // Méthode affiche liste d'auteurs dans la bdd
    /**
     * @Route("/admin/author-list", name="admin_author_list")
     */
    public function authorList(AuthorRepository $authorRepository){
        $authors = $authorRepository->findAll();

        return $this->render('admin/author-list.html.twig', [
            'authors' => $authors
        ]);
    }

    // Méthode affichage de la fiche d'un auteur
    /**
     * @Route("/admin/author-show/{id}", name="admin_author_show")
     */
    public function authorShow($id, AuthorRepository $authorRepository){
        $author = $authorRepository->find($id);
        return $this->render('admin/author-show.html.twig', [
            'author' => $author
        ]);
    }

    // Méthode d'insertion d'auteur dans la bdd
    /**
     * @Route("/admin/author-insert",name="admin_author_insert")
     */
    public function authorInsert(EntityManagerInterface $entityManager, Request $request){
        $author = new Author();
        // Création d'un formulaire lié à la table Article via ses paramètres lié à l'instance d'Article
        $form = $this->createForm(AuthorType::class, $author);

        // On donne la variable form une instance de Request pour que le formulaire puisse
        // récupérer les données et les traiter automatiquement
        $form->handleRequest($request);

        // Si le formulaire à été posté et que les données sont valides, on envoie sur la base de données
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($author);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez bien ajouté votre auteur');
        }

        return $this->render('admin/author-insert.html.twig', [
            // Utilisation de la méthode createView pour créer la view du formulaire
            'form' => $form->createView()
        ]);

    }

    // Méthode de suppression d'auteur de la bdd
    /**
     * @Route("/admin/author-delete/{id}", name="admin_author_delete")
     */
    public function authorDelete($id, EntityManagerInterface $entityManager, AuthorRepository $authorRepository){
        $author = $authorRepository->find($id);
        if(!is_null($author)){
            $entityManager->remove($author);
            $entityManager->flush();

            $this->addFlash('success', "Vous avez bien supprimé l'auteur");
            return $this->redirectToRoute('admin_author_list');
        }
        $this->addFlash('error', 'Auteur introuvable');
        return $this->redirectToRoute('admin_author_list');
    }

    // Méthode d'update d'auteur dans la bdd
    /**
     * @Route("/admin/author-update/{id}", name="admin_author_update")
     */
    public function authorUpdate($id, AuthorRepository $authorRepository, EntityManagerInterface $entityManager, Request $request){
        $author = $authorRepository->find($id);
        // Création d'un formulaire lié à la table Article via ses paramètres lié à l'instance d'Article
        $form = $this->createForm(AuthorType::class, $author);

        // On donne la variable form une instance de Request pour que le formulaire puisse
        // récupérer les données et les traiter automatiquement
        $form->handleRequest($request);

        // Si le formulaire à été posté et que les données sont valides, on envoie sur la base de données
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($author);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez bien ajouté votre auteur');
        }

        return $this->render('admin/author-update.html.twig', [
            // Utilisation de la méthode createView pour créer la view du formulaire
            'form' => $form->createView()
        ]);

    }
}