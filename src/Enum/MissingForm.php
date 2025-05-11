<?php

declare(strict_types=1);

namespace App\Enum;

enum MissingForm: int
{
    case BaseForm = 1;
    case PastSimple = 2;
    case PastParticiple = 3;
}
