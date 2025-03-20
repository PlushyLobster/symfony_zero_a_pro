<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $comment = new Comment();
            $comment->setContenu('Ceci est le contenu du commentaire');
            $comment->setAuthor('Amélie');
            $comment->setDateComment(new \DateTime());
            $article = $this->getReference('article-1', Article::class);
            $comment->setArticle($article);
            
            $manager->persist($comment);        
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArticleFixtures::class
        ];
    }
}
