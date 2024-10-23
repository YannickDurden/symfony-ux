<?php

namespace App\DTO;

class CoreDTO
{
    public string $core;
    public int $flight;
    public ?bool $gridfins = null;
    public ?bool $legs = null;
    public ?bool $reused = null;
    public ?bool $landing_attempt = null;
    public ?bool $landing_success = null;
    public ?string $landing_type;
    public ?string $landpad;

    public function __construct(array $core)
    {
        $this->core = $core['core'];
        $this->flight = $core['flight'];
        $this->gridfins = $core['gridfins'];
        $this->legs = $core['legs'];
        $this->reused = $core['reused'];
        $this->landing_attempt = $core['landing_attempt'];
        $this->landing_success = $core['landing_success'];
        $this->landing_type = $core['landing_type'];
        $this->landpad = $core['landpad'];
    }
}
