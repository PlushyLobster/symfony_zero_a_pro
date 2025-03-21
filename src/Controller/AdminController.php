<?php

namespace App\Controller;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/admin')]

final class AdminController extends AbstractController
{

    //ajoute un article
    #[Route('/article/ajouter', name: 'ajout_article')]
    #[Route('/article/{id}/edition', name: 'edition_article', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function ajouter(?Article $article, Request $request, EntityManagerInterface $manager): Response
    {        
        if($article === null){
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($form->get('brouillon')->isSubmitted()){
                $article->setState('brouillon');
            } else {
                $article->setState('a publier');
            }

            if($article->getId() === null){
                $manager->persist($article);
            }
            $manager->flush();

            return $this->redirectToRoute('list_article');

        }
    
        return $this->render('default/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

        //Ajouter une categorie
        #[Route('/categorie/ajouter', name: 'ajout_categorie')]
        public function ajouter_categorie(Request $request, EntityManagerInterface $manager): Response
        {
            $category = new Category();

            $form = $this->createForm(CategoryType::class, $category);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $manager->persist($category);
                $manager->flush();

                return $this->redirectToRoute('list_article');

            }

            return $this->render('default/ajout_category.html.twig', [
                'form' => $form->createView()
            ]);
        }

        #[Route('/article/brouillon', name: 'brouillon_article')]
        public function brouillon(ArticleRepository $articleRepository): Response
        {
            $articles = $articleRepository->findBy([
                'state' => 'brouillon'
            ]);

            return $this->render('default/index.html.twig', [
                'articles' => $articles,
                'brouillon' => true, 
            ]);
        }

}
