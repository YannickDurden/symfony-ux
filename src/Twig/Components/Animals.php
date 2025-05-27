<?php

namespace App\Twig\Components;

use App\Manager\AnimalManager;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
final class Animals
{
    public array  $animals;
    public string $animalType;

    public function __construct(
        private readonly AnimalManager $animalManager,
    ) {}

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(ignore: true);

        $resolver->setDefaults(['animalType' => 'cat']);
        $resolver->setAllowedValues('animalType', ['cat', 'dog']);

        return $resolver->resolve($data) + $data;
    }

    #[PostMount]
    public function postMount(array $data): void
    {
        $animalMethod = match ($this->animalType) {
            'cat' => 'getCatsList',
            'dog' => 'getDogsList'
        };
        
        $this->animals = $this->animalManager->$animalMethod();
    }
}
