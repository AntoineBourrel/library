<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
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
    public function authorInsert(EntityManagerInterface $entityManager){
        $author = new Author();
        $author->setFirstName('John');
        $author->setLastName('Tolkien');
        $author->setBirthDate(new \DateTime('1892-01-03'));
        $author->setDeathDate(new \DateTime('1973-09-02'));

        $entityManager->persist($author);
        $entityManager->flush();

        $this->addFlash('success', 'Vous avez bien ajouté votre auteur');
        return $this->redirectToRoute('admin_author_list');
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
    public function authorUpdate($id, AuthorRepository $authorRepository, EntityManagerInterface $entityManager){
        $author = $authorRepository->find($id);
        $author->setFirstName('Test');
        $author->setLastName('Update');
        $author->setBirthDate(new \DateTime('now'));
        $author->setDeathDate(null);

        $entityManager->persist($author);
        $entityManager->flush();

        $this->addFlash('success', 'Vous avez bien modifié votre auteur');
        return $this->redirectToRoute('admin_author_list');
    }
}