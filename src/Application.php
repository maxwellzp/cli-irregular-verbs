<?php

namespace App;

use App\Model\MissingForm;
use App\Model\Question;
use Maxwellzp\EnglishIrregularVerbs\Factory\IrregularVerbFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question as SymfonyQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class Application
{
    private int $totalCorrectAnswers = 0;
    private int $totalWrongAnswers = 0;
    private int $totalQuestionsProcessed = 0;
    const NUMBER_OF_QUESTIONS = 10;

    public function __construct(private readonly SymfonyStyle $io)
    {
    }

    public function run()
    {
        $this->io->title('The quiz has started');
        $this->io->info('q = quit | s = skip');

        $factory = new IrregularVerbFactory();
        $randomSet = $factory->getRandomSet(self::NUMBER_OF_QUESTIONS);

        /** @var Question[] $questions */
        $questions = array_map(function ($verb) {
            $x = match (rand(1, 3)) {
                1 => MissingForm::BaseForm,
                2 => MissingForm::PastSimple,
                3 => MissingForm::PastParticiple,
            };
            return new Question($verb, $x);
        }, $randomSet);


        foreach ($questions as $question) {

            $symfonyQuestion = new SymfonyQuestion(sprintf(
                'Please enter the missing verb form. %s %s', PHP_EOL, $question->display()
            ));
            $answer = $this->io->askQuestion($symfonyQuestion);
            if ($answer === "s") {
                continue;
            }
            if ($answer === "q") {
                return Command::SUCCESS;
            }

            $this->io->note("You answer: " . $answer);

            if ($answer === $question->getAnswer()) {
                $this->io->success('You answer is correct!');
            } else {
                $this->io->error('You answer is not correct!');
            }
        }
    }
}