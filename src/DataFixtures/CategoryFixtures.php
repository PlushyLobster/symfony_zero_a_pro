<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Article;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sport = new Category();
        $sport->setName('Sport');

        $sport->addArticle($this->getReference('article-1', Article::class));
        $sport->addArticle($this->getReference('article-2', Article::class));
        $sport->addArticle($this->getReference('article-3', Article::class));

        $manager->persist($sport);

        $maison = new Category();
        $maison->setName('Maison');

        $maison->addArticle($this->getReference('article-2', Article::class));
        $maison->addArticle($this->getReference('article-3', Article::class));
        $maison->addArticle($this->getReference('article-4', Article::class));

        $manager->persist($maison);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArticleFixtures::class
        ];
    }
}
