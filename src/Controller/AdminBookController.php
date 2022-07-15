<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route ("/admin/book-show/" name="admin_book_show")
     */
}