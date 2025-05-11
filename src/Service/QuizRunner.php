<?php

declare(strict_types=1);

namespace App\Service;

use App\Console\QuizPresenter;
use Maxwellzp\EnglishIrregularVerbs\Repository\IrregularVerbRepository;
use Symfony\Component\Console\Style\SymfonyStyle;

class QuizRunner
{
    public function __construct(
        private readonly IrregularVerbRepository $repository,
    ) {}

    public function run(SymfonyStyle $io, int $questionCount): void
    {
        $quizService = new QuizService($this->repository);
        $presenter = new QuizPresenter($io, $quizService);

        $presenter->displayTitle();

        $questions = $quizService->getQuestions($questionCount);

        foreach ($questions as $question) {
            $answer = $presenter->askQuestion($question);

            if ($answer === null) {
                return;
            }

            $presenter->displayResult($answer, $question);
        }

        $presenter->displayFooter();
    }
}
