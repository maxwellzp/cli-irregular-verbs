<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\QuizRunner;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:grammar-quiz',
    description: 'Run an English irregular verb grammar quiz',
)]
class GrammarQuizCommand extends Command
{
    public function __construct(private readonly QuizRunner $quizRunner)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('count', InputArgument::OPTIONAL, 'Number of quiz questions', 5);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $count = (int) $input->getArgument('count');
        $this->quizRunner->run($io, $count);

        return Command::SUCCESS;
    }
}
