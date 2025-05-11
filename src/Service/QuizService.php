<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\MissingForm;
use App\Model\Question;
use App\Model\QuizResult;
use Maxwellzp\EnglishIrregularVerbs\Model\IrregularVerb;
use Maxwellzp\EnglishIrregularVerbs\Repository\IrregularVerbRepository;

class QuizService
{
    private readonly QuizResult $quizResult;

    public function __construct(private IrregularVerbRepository $irregularVerbRepository)
    {
        $this->quizResult = new QuizResult();
    }

    public function getIrregularVerbs($num): array
    {
        return $this->irregularVerbRepository->getRandomSet($num);
    }

    public function createQuestions(array $irregularVerbs): array
    {
        return array_map([$this, 'createQuestion'], $irregularVerbs);
    }

    public function createQuestion(IrregularVerb $irregularVerb): Question
    {
        $missingForm = match (rand(1, 3)) {
            1 => MissingForm::BaseForm,
            2 => MissingForm::PastSimple,
            3 => MissingForm::PastParticiple,
        };
        return new Question($irregularVerb, $missingForm);
    }

    public function checkIfAnswerCorrect(string $answer, Question $question): bool
    {
        $isCorrect = mb_strtolower(trim($answer)) === mb_strtolower($question->getAnswer());

        if ($isCorrect) {
            $this->quizResult->plusCorrectAnswer();
        } else {
            $this->quizResult->plusNotCorrectAnswer();
        }

        return $isCorrect;
    }

    /**
     * @param int $num
     * @return Question[]
     */
    public function getQuestions(int $num): array
    {
        $irregularVerbs = $this->getIrregularVerbs($num);
        return $this->createQuestions($irregularVerbs);
    }

    /**
     * @return QuizResult
     */
    public function getQuizResult(): QuizResult
    {
        return $this->quizResult;
    }
}
