<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Model\QuizResult;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(QuizResult::class)]
class QuizResultTest extends TestCase
{
    public function test(): void
    {
        // Arrange
        $quizResult = new QuizResult();

        // Act
        $quizResult->plusCorrectAnswer();

        // Assert
        $this->assertEquals(1, $quizResult->getTotalCorrectAnswers());
    }

    public function test2(): void
    {
        // Arrange
        $quizResult = new QuizResult();

        // Act
        $quizResult->plusNotCorrectAnswer();

        // Assert
        $this->assertEquals(1, $quizResult->getTotalNotCorrectAnswers());
    }

    public function test3(): void
    {
        // Arrange
        $quizResult = new QuizResult();

        // Act
        $quizResult->plusCorrectAnswer();
        $quizResult->plusCorrectAnswer();
        $quizResult->plusCorrectAnswer();
        $quizResult->plusNotCorrectAnswer();
        $quizResult->plusNotCorrectAnswer();

        // Assert
        $this->assertEquals("3/5", $quizResult->__toString());
    }
}
