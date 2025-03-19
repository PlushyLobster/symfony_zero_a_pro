<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleRepository;

final class DefaultController extends AbstractController
{
    // / qui vas lister l'ensemble de nos articles 
    #[Route('/', name: 'list_article', methods: ['GET'])]
    public function list_article(ArticleRepository $articleRepository): Response
    {

        $articles = $articleRepository->findAll();

        return $this->render('default/index.html.twig', [
            'articles' => $articles,
        ]);
    }


    // /12 qui vas afficher un article en particulier
    #[Route('/{id}', name: 'vue_article', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function vue_article(Article $article): Response
    {   
        //$article = $articleRepository->find($id);

        return $this->render('default/vue.html.twig', [
            'article' => $article,
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
