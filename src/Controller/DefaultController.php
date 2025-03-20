<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository; 

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
    public function ajouter(Request $request, CategoryRepository $categorieRepository, EntityManagerInterface $manager): Response
    {
        $form = $this->createFormBuilder()
        ->add('titre', TextType::class,[
            'label' => 'Titre de l\'article'
        ])
        ->add('contenu', TextareaType::class)
        ->add('dateCreation', DateType::class, [
            'widget' => 'single_text'
        ])
        ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $article = new Article();
            $article->setTitre($form->get('titre')->getData());
            $article->setContenu($form->get('contenu')->getData());
            $article->setDateCreation($form->get('dateCreation')->getData());

            $category = $categorieRepository->findOneBy([
                'name' => 'Sport'
            ]);

            $article->addCategory($category);
            
            $manager->persist($article);

            $manager->flush();
            
            return $this->redirectToRoute('list_article');
        }

        return $this->render('default/ajout.html.twig', [
            'form' => $form->createView()
        ]);

    }

    
}
