<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $states = ['brouillon', 'publie'];  

        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitre('Article n°' . $i);
            $article->setContenu('Ceci est le contenu de l\'article ');
            $article->setState($states[array_rand($states)]);

            $date= new \DateTime();
            $date->modify('-' . $i . ' days');

            $article->setDateCreation($date);

            $this->addReference('article-'.$i, $article);


            $manager->persist($article);
        }

        $manager->flush();
    }
}
