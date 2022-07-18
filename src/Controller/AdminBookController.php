<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdminBookController extends AbstractController
{
    // Méthode liste de livre en bdd
    /**
     * @Route ("/admin/book-list", name="admin_book_list")
     */
    public function bookList(BookRepository $bookRepository){
        $books = $bookRepository->findAll();

        return $this->render('admin/book-list.html.twig', [
            'books' => $books
        ]);
    }

    // Méthode affichage détaillé de la fiche du livre
    /**
     * @Route ("/admin/book-show/{id}", name="admin_book_show")
     */

    public function bookShow($id, BookRepository $bookRepository){
        $book = $bookRepository->find($id);
        return $this->render('admin/book-show.html.twig', [
            'book' => $book
        ]);
    }

    // Méthode insertion de fiche livre
    /**
     * @Route ("/admin/book-insert", name="admin_book_insert")
     */
    public function bookInsert(EntityManagerInterface $entityManager, Request $request){
        $book = new Book();
        // Création d'un formulaire lié à la table Article via ses paramètres lié à l'instance d'Article
        $form = $this->createForm(BookType::class, $book);

        // On donne la variable form une instance de Request pour que le formulaire puisse
        // récupérer les données et les traiter automatiquement
        $form->handleRequest($request);

        // Si le formulaire à été posté et que les données sont valides, on envoie sur la base de données
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez bien ajouté votre livre');
        }

        return $this->render('Admin/book-insert.html.twig', [
            // Utilisation de la méthode createView pour créer la view du formulaire
            'form' => $form->createView()
        ]);

    }

    // Méthode suppression de fiche de livre
    /**
     * @Route ("/admin/book-delete/{id}", name="admin_book_delete")
     */
    public function bookDelete($id, EntityManagerInterface $entityManager, BookRepository $bookRepository){
        $book = $bookRepository->find($id);
        if(!is_null($book))
        {
            $entityManager->remove($book);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez bien supprimé votre livre');
            return $this->redirectToRoute('admin_book_list');
        }
        $this->addFlash('error', 'Livre introuvable');
        return $this->redirectToRoute('admin_book_list');
    }

    // Méthode Update de fiche de livre
    /**
     * @Route("/admin/book-update/{id}", name="admin_book_update")
     */
    public function bookUpdate($id, BookRepository $bookRepository, EntityManagerInterface $entityManager, Request $request){
        $book = $bookRepository->find($id);
        // Création d'un formulaire lié à la table Article via ses paramètres lié à l'instance d'Article
        $form = $this->createForm(BookType::class, $book);

        // On donne la variable form une instance de Request pour que le formulaire puisse
        // récupérer les données et les traiter automatiquement
        $form->handleRequest($request);

        // Si le formulaire à été posté et que les données sont valides, on envoie sur la base de données
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez bien ajouté votre livre');
        }

        return $this->render('Admin/book-insert.html.twig', [
            // Utilisation de la méthode createView pour créer la view du formulaire
            'form' => $form->createView()
        ]);
    }

    //méthode de recherche d'un titre dans la bdd
    /**
     * @Route("/admin/book-search", name="admin_book_search")
     */
    public function bookSearch(Request $request, BookRepository $bookRepository, AuthorRepository $authorRepository){
        // Récupération valeur GET dans l'URL
        $search = $request->query->get('search');

        // je vais créer une méthode dans le BookRepository
        // qui trouve un livre en fonction d'un mot dans son titre
        $books = $bookRepository->searchByWord($search);
        $authors = $authorRepository->searchByWord($search);


        // Renvoie vers le fichier twig
        return $this->render('admin/book-search.html.twig', [
            'books' => $books,
            'authors' =>$authors
        ]);
    }
}