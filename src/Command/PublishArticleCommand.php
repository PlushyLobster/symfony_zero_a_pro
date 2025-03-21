<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:publish-article',
    description: 'Publie les articles à publier ',
)]
class PublishArticleCommand extends Command
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $manager)
    {
        $this->articleRepository = $articleRepository;
        $this->manager = $manager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $articles = $this->articleRepository->findBy([
            'state' => 'a publier'
        ]);

        foreach ($articles as $article) {
            $article->setState('publie');
        }

        $this->manager->flush();

        $io->success(count($article) . 'articles publiés avec succès.');

        return Command::SUCCESS;
    }
}
