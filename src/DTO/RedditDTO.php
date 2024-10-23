<?php

namespace App\DTO;

class RedditDTO
{
    public ?string $campaign;
    public ?string $launch;
    public ?string $media;
    public ?string $recovery;

    public function __construct(array $reddit)
    {
        $this->campaign = $reddit['campaign'];
        $this->launch = $reddit['launch'];
        $this->media = $reddit['media'];
        $this->recovery = $reddit['recovery'];
    }
}
