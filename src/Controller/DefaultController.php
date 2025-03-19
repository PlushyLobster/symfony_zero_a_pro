<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

final class DefaultController extends AbstractController
{
    // / qui vas lister l'ensemble de nos articles 
    #[Route('/', name: 'list_article', methods: ['GET'])]
    public function list_article(): Response
    {

        $articles = [
            ['nom' => 'Article 1', 'id' => 1],
            ['nom' => 'Article 2', 'id' => 2],
            ['nom' => 'Article 3', 'id' => 3],
            ['nom' => 'Article 4', 'id' => 4],

        ];

        return $this->render('default/index.html.twig', [
            'articles' => $articles,
        ]);
    }


    // /12 qui vas afficher un article en particulier
    #[Route('/{id}', name: 'vue_article', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function vue_article($id): Response
    {
        return $this->render('default/vue.html.twig', [
            'id' => $id,
        ]);
    }

    //ajoute un article
    #[Route('/article/ajouter', name: 'ajout_article')]
    public function ajouter(EntityManagerInterface $manager): Response
    {
        $article = new Article();
        $article->setTitre('Titre de l\'article');
        $article->setContenu('Ceci est le contenu de l\'article');
        $article->setDateCreation(new \DateTime());

        $manager->persist($article);
        $manager->flush();


    }
}
