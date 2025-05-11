<?php

declare(strict_types=1);

namespace App\Console;

use App\Model\Question;
use App\Service\QuizService;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\Question as SymfonyQuestion;

class QuizPresenter
{
    public function __construct(
        private readonly SymfonyStyle $io,
        private readonly QuizService  $quizService,
    )
    {
    }

    public function displayTitle(): void
    {
        $this->io->title('The quiz has started. [Press enter to quit]');
    }

    public function displayFooter(): void
    {
        $this->io->title('The quiz has been completed. Your result: ' . $this->quizService->getQuizResult());
    }

    public function askQuestion(Question $question): ?string
    {
        $symfonyQuestion = new SymfonyQuestion(sprintf(
            'Please enter the missing verb form.%s%s',
            PHP_EOL,
            $question->getGuessString()
        ));

        return $this->io->askQuestion($symfonyQuestion);
    }

    public function displayResult(string $answer, Question $question): void
    {
        if ($this->quizService->checkIfAnswerCorrect($answer, $question)) {
            $this->io->success('Your answer is correct!');
        } else {
            $this->io->error('Your answer is incorrect!');
        }
    }
}
