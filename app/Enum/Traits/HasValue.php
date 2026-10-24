<?php

declare(strict_types=1);

namespace App\Enum\Traits;

trait HasValue
{
    /**
     * @return string[]
     */
    public static function value(): array
    {
        return array_column(self::cases(), 'value');
    }
}
