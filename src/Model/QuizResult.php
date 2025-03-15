<?php

declare(strict_types=1);

namespace App\Model;

class QuizResult
{
    public function __construct(
        private int $totalCorrectAnswers = 0,
        private int $totalNotCorrectAnswers = 0
    ) {
    }

    public function getTotalCorrectAnswers(): int
    {
        return $this->totalCorrectAnswers;
    }

    public function getTotalNotCorrectAnswers(): int
    {
        return $this->totalNotCorrectAnswers;
    }

    public function getTotalQuestionsProcessed(): int
    {
        return $this->totalCorrectAnswers + $this->totalNotCorrectAnswers;
    }

    public function plusCorrectAnswer(): void
    {
        $this->totalCorrectAnswers++;
    }

    public function plusNotCorrectAnswer(): void
    {
        $this->totalNotCorrectAnswers++;
    }

    public function __toString(): string
    {
        return sprintf("%d/%d", $this->totalCorrectAnswers, $this->getTotalQuestionsProcessed());
    }
}
