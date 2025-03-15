<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Model\MissingForm;
use App\Model\Question;
use Maxwellzp\EnglishIrregularVerbs\Model\IrregularVerb;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Question::class)]
class QuestionTest extends TestCase
{
    #[DataProvider('guessStringProvider')]
    public function testGetGuessStringReturnsCorrectResult(string $expectedGuessString, MissingForm $missingForm): void
    {
        // Arrange
        $verb = new IrregularVerb('do', 'did', 'done');
        $question = new Question($verb, $missingForm);

        // Act
        $guessString = $question->getGuessString();

        // Assert
        $this->assertEquals($expectedGuessString, $guessString);
    }

    public static function guessStringProvider(): \Generator
    {
        yield ["[-] - [did] - [done]", MissingForm::BaseForm];
        yield ["[do] - [-] - [done]", MissingForm::PastSimple];
        yield ["[do] - [did] - [-]", MissingForm::PastParticiple];
    }

    public function testGetMissingForm(): void
    {
        // Arrange
        $verb = new IrregularVerb('do', 'did', 'done');
        $missingForm = MissingForm::BaseForm;
        $question = new Question($verb, $missingForm);

        // Act
        $missingForm = $question->getMissingForm();

        // Assert
        $this->assertInstanceOf(MissingForm::class, $missingForm);
    }

    public function testGetIrregularVerbGetter(): void
    {
        // Arrange
        $verb = new IrregularVerb('do', 'did', 'done');
        $missingForm = MissingForm::BaseForm;
        $question = new Question($verb, $missingForm);

        // Act
        $verb = $question->getIrregularVerb();

        // Assert
        $this->assertInstanceOf(IrregularVerb::class, $verb);
    }

    #[DataProvider('correctAnswerProvider')]
    public function testGetAnswerReturnsCorrectResult($expectedVerb, $missingForm): void
    {
        // Arrange
        $verb = new IrregularVerb('do', 'did', 'done');
        $question = new Question($verb, $missingForm);

        // Act
        $answer = $question->getAnswer();

        // Assert
        $this->assertEquals($expectedVerb, $answer);
    }

    public static function correctAnswerProvider(): \Generator
    {
        yield ["do", MissingForm::BaseForm];
        yield ["did", MissingForm::PastSimple];
        yield ["done", MissingForm::PastParticiple];
    }
}
