<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Traits\HasLabel;
use App\Enum\Traits\HasValue;

enum RoleEnum: string
{
    use HasLabel;
    use HasValue;

    case ADMIN = 'admin';
    case SURVEYOR = 'surveyor';
    case RESIDENT = 'resident';

}
