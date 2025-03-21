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
use App\Form\ArticleType;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\Category;
use App\Form\CategoryType;
use Psr\Log\LoggerInterface;
use App\Service\VerificationComment;

final class DefaultController extends AbstractController
{
    // / qui vas lister l'ensemble de nos articles 
    #[Route('/', name: 'list_article', methods: ['GET'])]
    public function list_article(ArticleRepository $articleRepository): Response
    {

        $articles = $articleRepository->findBy([
            'state' => 'publie'
        ]);

        return $this->render('default/index.html.twig', [
            'articles' => $articles,
            'brouillon' => false,
        ]);
    }


    // /12 qui vas afficher un article en particulier
    #[Route('/{id}', name: 'vue_article', requirements: ['id' => '\d+'], methods: ['GET','POST'])]

// /12 qui vas afficher un article en particulier
#[Route('/{id}', name: 'vue_article', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
public function vue_article(Article $article, Request $request, EntityManagerInterface $manager, VerificationComment $verifService): Response
{   
    $comment = new Comment();
    $comment->setArticle($article);

    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        if ($verifService->commentaireNonAutorise($comment) === false) {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', 'Votre commentaire a été ajouté avec succès.');

            return $this->redirectToRoute('vue_article', ['id' => $article->getId()]);
        } else {
            $this->addFlash('warning', 'Votre commentaire contient des mots interdits');      
            return $this->redirectToRoute('vue_article', ['id' => $article->getId()]);  

        }
    }

    return $this->render('default/vue.html.twig', [
        'article' => $article,
        'form' => $form->createView()
    ]);
}


    
}
