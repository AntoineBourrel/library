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

class FrontAuthorController extends AbstractController
{
    // Méthode affiche liste d'auteurs dans la bdd
    /**
     * @Route("/author-list", name="author_list")
     */
    public function authorList(AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->findAll();

        return $this->render('front/author-list.html.twig', [
            'authors' => $authors
        ]);
    }

    // Méthode affichage de la fiche d'un auteur

    /**
     * @Route("/author-show/{id}", name="author_show")
     */
    public function authorShow($id, AuthorRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        return $this->render('front/author-show.html.twig', [
            'author' => $author
        ]);
    }
}
