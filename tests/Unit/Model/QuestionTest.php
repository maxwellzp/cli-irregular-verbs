<?php
declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Model\MissingForm;
use App\Model\Question;
use Maxwellzp\EnglishIrregularVerbs\Model\IrregularVerb;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Question::class)]
class QuestionTest extends TestCase
{
    public function testGetGuessString(): void
    {
        // Arrange
        $verb = new IrregularVerb('do','did','done');
        $missingForm = MissingForm::BaseForm;
        $question = new Question($verb, $missingForm);

        // Act
        $guessString = $question->getGuessString();

        // Assert
        $this->assertEquals("[-] - [did] - [done]", $guessString);
    }
    public function testGetMissingForm(): void
    {
        // Arrange
        $verb = new IrregularVerb('do','did','done');
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
        $verb = new IrregularVerb('do','did','done');
        $missingForm = MissingForm::BaseForm;
        $question = new Question($verb, $missingForm);

        // Act
        $verb = $question->getIrregularVerb();

        // Assert
        $this->assertInstanceOf(IrregularVerb::class, $verb);
    }
}
