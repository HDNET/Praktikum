<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OutputHtmlCommand extends Command
{
    protected static $defaultName = 'app:generate-html';

    private \Twig\Environment $twig;

    public function __construct(\Twig\Environment $twig)
    {
        parent::__construct();

        $this->twig = $twig;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $content = $this->twig->render('landingpage/index.html.twig', [
            'form' => null,
            'showDownloadButton' => false,
            'hash' => null,
        ]);

        \file_put_contents('public/index.html', $content);

        return Command::SUCCESS;
    }
}
