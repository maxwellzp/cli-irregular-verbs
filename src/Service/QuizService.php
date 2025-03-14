<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\MissingForm;
use App\Model\Question;
use App\Model\QuizResult;
use Maxwellzp\EnglishIrregularVerbs\Factory\IrregularVerbFactory;
use Maxwellzp\EnglishIrregularVerbs\Model\IrregularVerb;

class QuizService
{
    private readonly QuizResult $quizResult;

    public function __construct()
    {
        $this->quizResult = new QuizResult();
    }

    public function getIrregularVerbs($num): array
    {
        $factory = new IrregularVerbFactory();
        return $factory->getRandomSet($num);
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
        if ($answer === $question->getAnswer()) {
            $this->quizResult->plusCorrectAnswer();
            return true;
        } else {
            $this->quizResult->plusNotCorrectAnswer();
            return false;
        }
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