<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    // / qui vas lister l'ensemble de nos articles 
    #[Route('/', name: 'list_article', methods: ['GET'])]
    public function list_article(): Response
    {
        $url1 = $this->generateUrl('vue_article', ['id' => 1]);
        $url2 = $this->generateUrl('vue_article', ['id' => 2]);
        $url3 = $this->generateUrl('vue_article', ['id' => 3]);

        return $this->render('default/index.html.twig', [
            'url1' => $url1,
            'url2' => $url2,
            'url3' => $url3,
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
}
