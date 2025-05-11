<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Enum\MissingForm;
use App\Model\Question;
use App\Service\QuizService;
use Maxwellzp\EnglishIrregularVerbs\Model\IrregularVerb;
use Maxwellzp\EnglishIrregularVerbs\Repository\IrregularVerbRepository;
use PHPUnit\Framework\TestCase;

class QuizServiceTest extends TestCase
{
    public function testCreateQuestionRandomForm(): void
    {
        $repo = $this->createMock(IrregularVerbRepository::class);
        $service = new QuizService($repo);

        $verb = new IrregularVerb('make', 'made', 'made');
        $question = $service->createQuestion($verb);

        $this->assertInstanceOf(Question::class, $question);
        $this->assertSame($verb, $question->getIrregularVerb());
    }

    public function testCheckIfAnswerCorrect(): void
    {
        $repo = $this->createMock(IrregularVerbRepository::class);
        $service = new QuizService($repo);

        $verb = new IrregularVerb('run', 'ran', 'run');
        $question = new Question($verb, MissingForm::PastSimple);

        $this->assertTrue($service->checkIfAnswerCorrect('ran', $question));
        $this->assertFalse($service->checkIfAnswerCorrect('run', $question));
    }
}
