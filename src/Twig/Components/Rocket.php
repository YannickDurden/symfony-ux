<?php

namespace App\Twig\Components;

use App\DTO\RocketDTO;
use App\Client\SpacexClient;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Rocket
{
    public string $id;
    public RocketDTO $rocket;

    public function __construct(
        private readonly SpacexClient $spacexClient,
    ) {}

    public function getRocket(): RocketDTO
    {
        return $this->rocket;
    }

    #[PostMount]
    public function postMount(): void
    {
        $this->rocket = $this->spacexClient->fetchRocketById($this->id);
    }
}
