<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // Création de la route vers l'accueil
    /**
     * @Route ("/", name="home")
     */
    public function home(BookRepository $bookRepository)
    {
        $lastBooks = $bookRepository->findBy([], ['id' => 'DESC'],3);
        return $this->render('home.html.twig', [
            'lastBooks' => $lastBooks
        ]);
    }
}
