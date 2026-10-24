<?php

declare(strict_types=1);

namespace App\Enum\Traits;

trait HasLabel
{
    public function label(): string
    {
        return $this->value;
    }
}
