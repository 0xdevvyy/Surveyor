<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Traits\HasLabel;
use App\Enum\Traits\HasValue;

enum SuffixEnum: string
{
    use HasLabel;
    use HasValue;

    case JR = 'Jr.';
    case SR = 'Sr.';
    case I = 'I';
    case II = 'II';
    case III = 'III';
    case IV = 'IV';
    case V = 'V';
    case VI = 'VI';
    case VII = 'VII';
    case VIII = 'VIII';
    case IX = 'IX';
    case X = 'X';
}
