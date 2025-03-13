<?php

namespace App\Twig\Components;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsTwigComponent(template: 'components/Card.html.twig')]
final class Card
{
    public bool $canBuy = false;

    public string $type;
    public string $title;
    public string $url = '#';
    public string $description;

    #[ExposeInTemplate(name: 'image_url')]
    public string $image;
    #[ExposeInTemplate(name: 'label')]
    public string $buttonLabel;

    public function __construct(
        private readonly CacheInterface $cache,
        private readonly HttpClientInterface $httpClient,
        #[Autowire('%env(CAT_API_KEY)%')] private readonly string $catApiKey,
    ) {}

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(ignore: true);

        $resolver->setDefaults(['type' => 'cat']);
        $resolver->setAllowedValues('type', ['cat', 'dog']);

        return $resolver->resolve($data) + $data;
    }

    public function mount(bool $isLoggedIn = false): void
    {
        $this->canBuy = $isLoggedIn;
    }

    #[PostMount]
    public function postMount(): void
    {
        $this->image = $this->getImage();
    }

    private function getImage(): string
    {
        $images = match ($this->type) {
            'cat' => $this->getCatsImage(),
            'dog' => $this->getDogsImage(),
        };

        return $images[array_rand($images)]['url'];
    }

    private function getCatsImage(): mixed
    {
        return $this->cache->get('cats_image', function (ItemInterface $item) {
            $item->expiresAfter(7200);

            $request = $this->httpClient->request(
                'GET',
                'https://api.thecatapi.com/v1/images/search?size=med&mime_types=jpg&format=json&has_breeds=true&order=RANDOM&page=0&limit=10',
                [
                    'headers' => [
                        'x-api-key' => $this->catApiKey,
                        'Content-Type' => 'application/json',
                    ],
                ]
            );

            return $request->toArray();
        });
    }

    private function getDogsImage(): array
    {
        $dogsImage = $this->cache->get('dogs_image', function (ItemInterface $item) {
            $item->expiresAfter(7200);

            $request = $this->httpClient->request(
                'GET',
                'https://dog.ceo/api/breeds/image/random/10',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                ]
            );

            return $request->toArray();
        });

        foreach ($dogsImage['message'] as $key => $value) {
            $dogsImage['message'][$key] = ['url' => $value];
        }

        return $dogsImage['message'];
    }
}
