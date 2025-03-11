<?php

namespace App\Model;

use Maxwellzp\EnglishIrregularVerbs\Model\IrregularVerb;

class Question
{
    public function __construct(
        private readonly IrregularVerb $irregularVerb,
        private readonly MissingForm $missingForm,
    ) {
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
    public function display(): string
    {
        return match ($this->missingForm) {
            MissingForm::BaseForm => sprintf("[%s] - [%s] - [%s]", "-", $this->irregularVerb->getPastSimple(), $this->irregularVerb->getPastParticiple()),
            MissingForm::PastSimple => sprintf("[%s] - [%s] - [%s]", $this->irregularVerb->getBaseForm(), "-", $this->irregularVerb->getPastParticiple()),
            MissingForm::PastParticiple => sprintf("[%s] - [%s] - [%s]", $this->irregularVerb->getBaseForm(), $this->irregularVerb->getPastSimple(), "-"),
        };
    }
}
