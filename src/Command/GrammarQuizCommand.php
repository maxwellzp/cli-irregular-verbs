<?php
declare(strict_types=1);

namespace App\Command;

use App\QuizApp;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:grammar-quiz',
    description: 'Add a short description for your command',
)]
class GrammarQuizCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $app = new QuizApp($io);
        $app->run();

        return Command::SUCCESS;
    }
}
