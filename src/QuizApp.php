<?php
declare(strict_types=1);

namespace App;

use App\Service\CliQuizService;
use Symfony\Component\Console\Style\SymfonyStyle;

class QuizApp
{
    private readonly CliQuizService $cliQuizService;

    public function __construct(SymfonyStyle $io)
    {
        $this->cliQuizService = new CliQuizService($io);
    }

    public function run(): void
    {
        $this->quizStart();
    }

    public function quizStart(): void
    {
        $this->cliQuizService->displayTitle();

        $questions = $this->cliQuizService->getQuizService()->getQuestions(5);
        foreach ($questions as $question) {
            $answer = $this->cliQuizService->askQuestion($question);
            if ($answer === null) {
                return;
            }
            $this->cliQuizService->displayResult($answer, $question);
        }
        $this->cliQuizService->displayFooter();
    }
}
