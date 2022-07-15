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
    /**
     * @Route ("/admin/book-list", name="admin_book_list")
     */
    public function bookList(BookRepository $bookRepository){
        $books = $bookRepository->findAll();

        return $this->render('admin/book-list.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route ("/admin/book-show", name="admin_book_show")
     */

    public function bookShow(BookRepository $bookRepository){
        //$book = $bookRepository->find($id);
        return $this->render('admin/book-show.html.twig'/*, [
            'book' => $book
        ]*/);
    }

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

        $this->addFlash('success', 'Vous avez bien ajouté votre article');
        return $this->redirectToRoute('admin_book_list');
    }
}