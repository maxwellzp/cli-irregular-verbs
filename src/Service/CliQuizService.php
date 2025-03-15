<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Question;
use Symfony\Component\Console\Question\Question as SymfonyQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class CliQuizService
{
    private QuizService $quizService;

    public function __construct(private SymfonyStyle $io)
    {
        $this->quizService = new QuizService();
    }

    public function displayTitle(): void
    {
        $this->io->title('The quiz has started. [Press enter to quit]');
    }
    public function displayFooter(): void
    {
        $quizResult = $this->getQuizService()->getQuizResult();
        $this->io->title('The quiz has been completed. Your result: ' . $quizResult);
    }

    public function createSymfonyQuestion(Question $question): SymfonyQuestion
    {
        return new SymfonyQuestion(sprintf(
            'Please enter the missing verb form. %s %s',
            PHP_EOL,
            $question->getGuessString()
        ));
    }

    public function displayResult(string $answer, Question $question): void
    {
        if ($this->quizService->checkIfAnswerCorrect($answer, $question)) {
            $this->io->success('You answer is correct!');
        } else {
            $this->io->error('You answer is not correct!');
        }
    }

    public function askQuestion(Question $question): mixed
    {
        $symfonyQuestion = $this->createSymfonyQuestion($question);
        return $this->io->askQuestion($symfonyQuestion);
    }

    public function getQuizService(): QuizService
    {
        return $this->quizService;
    }
}
