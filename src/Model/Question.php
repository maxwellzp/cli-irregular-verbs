<?php

declare(strict_types=1);

namespace App\Model;

use App\Enum\MissingForm;
use Maxwellzp\EnglishIrregularVerbs\Model\IrregularVerb;

class Question
{
    public function __construct(
        private readonly IrregularVerb $irregularVerb,
        private readonly MissingForm   $missingForm,
    )
    {
    }

    public function getIrregularVerb(): IrregularVerb
    {
        return $this->irregularVerb;
    }

    public function getMissingForm(): MissingForm
    {
        return $this->missingForm;
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return match ($this->missingForm) {
            MissingForm::BaseForm => $this->irregularVerb->getBaseForm(),
            MissingForm::PastSimple => $this->irregularVerb->getPastSimple(),
            MissingForm::PastParticiple => $this->irregularVerb->getPastParticiple(),
        };
    }

    /**
     * @return string
     */
    public function getGuessString(): string
    {
        [$baseForm, $pastSimple, $pastParticiple] = $this->getVerbPackedToArray();

        return match ($this->missingForm) {
            MissingForm::BaseForm => $this->createExercise(pastSimple: $pastSimple, pastParticiple: $pastParticiple),
            MissingForm::PastSimple => $this->createExercise(baseForm: $baseForm, pastParticiple: $pastParticiple),
            MissingForm::PastParticiple => $this->createExercise(baseForm: $baseForm, pastSimple: $pastSimple),
        };
    }

    public function getVerbPackedToArray(): array
    {
        return [$this->irregularVerb->getBaseForm(),
            $this->irregularVerb->getPastSimple(),
            $this->irregularVerb->getPastParticiple(),
        ];
    }


    public function createExercise(
        string $baseForm = "-",
        string $pastSimple = "-",
        string $pastParticiple = "-",
    ): string
    {
        return sprintf("[%s] - [%s] - [%s]", $baseForm, $pastSimple, $pastParticiple);
    }
}
