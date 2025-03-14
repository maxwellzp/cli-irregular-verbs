<?php
declare(strict_types=1);

namespace App\Tests\Unit\Command;

use App\QuizApp;
use App\Command\GrammarQuizCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GrammarQuizCommand::class)]
#[UsesClass(QuizApp::class)]
class GrammarQuizCommandTest extends TestCase
{
    public function testExecute(): void
    {

    }
}
