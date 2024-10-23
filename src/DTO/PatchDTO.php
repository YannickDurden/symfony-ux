<?php

namespace App\DTO;

class PatchDTO
{
    public ?string $small;
    public ?string $large;

    public function __construct(array $patch)
    {
        $this->small = $patch['small'] ?? null;
        $this->large = $patch['large'] ?? null;
    }
}
