<?php

namespace App\Controller;

use App\Entity\Book;
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
    public function bookInsert(EntityManagerInterface $entityManager){
        $book = new Book();
        $book->setTitle('The Fellowship of the Ring');
        $book->setNbPages(423);
        $book->setPublishedAt(new \DateTime('1954-07-29'));

        $entityManager->persist($book);
        $entityManager->flush();

        $this->addFlash('success', 'Vous avez bien ajouté votre livre');
        return $this->redirectToRoute('admin_book_list');
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
    public function bookUpdate($id, BookRepository $bookRepository, EntityManagerInterface $entityManager){
        $book = $bookRepository->find($id);
        $book->setTitle('Test Update');
        $book->setNbPages(0);
        book->setPublishedAt(new \DateTime('now'));

        $entityManager->persist($book);
        $entityManager->flush();

        $this->addFlash('success', 'Vous avez bien modifié votre livre');
        return $this->redirectToRoute('admin_book_list');

    }
}