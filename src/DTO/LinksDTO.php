<?php

namespace App\DTO;

class LinksDTO
{
    public PatchDTO $patch;
    public RedditDTO $reddit;
    public FlickrDTO $flickr;
    public ?string $presskit;
    public ?string $webcast;
    public ?string $youtube_id;
    public ?string $article;
    public ?string $wikipedia;

    public function __construct(array $links) {
        $this->patch = new PatchDTO($links['patch']);
        $this->reddit = new RedditDTO($links['reddit']);
        $this->flickr = new FlickrDTO($links['flickr']);
        $this->presskit = $links['presskit'];
        $this->webcast = $links['webcast'];
        $this->youtube_id = $links['youtube_id'];
        $this->article = $links['article'];
        $this->wikipedia = $links['wikipedia'];
    }
}
