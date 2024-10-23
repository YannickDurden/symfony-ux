<?php

namespace App\DTO;

class FlickrDTO
{
    public array $small;
    public array $original;

    public function __construct(array $flickr)
    {
        $this->small = $flickr['small'];
        $this->original = $flickr['original'];
    }
}
