<?php

namespace App\Manager;

use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class AnimalManager
{
    public function __construct(
        private CacheInterface                           $cache,
        private HttpClientInterface                      $httpClient,
        #[Autowire('%env(CAT_API_KEY)%')] private string $catApiKey,
    ) {}

    public function getCatsList(): array
    {
        $cats = [
            ['id' => 1,'name' => 'Hector', 'description' => 'Lorem ipsum dolor sit amet', 'available' => true],
            ['id' => 2,'name' => 'Jasmin', 'description' => 'Lorem ipsum dolor sit amet', 'available' => false],
            ['id' => 3,'name' => 'Booba', 'description' => 'Lorem ipsum dolor sit amet', 'available' => true],
        ];

        return array_map(function ($cat) {
            $catsImage = $this->getCatsImage();
            $cat['image'] = $catsImage[array_rand($catsImage)]['url'];

            return $cat;
        }, $cats);
    }

    public function getDogsList(): array
    {
        $dogs = [
            ['id' => 1,'name' => 'Rex', 'description' => 'Lorem ipsum dolor sit amet', 'available' => true],
            ['id' => 2,'name' => 'Buddy', 'description' => 'Lorem ipsum dolor sit amet', 'available' => false],
            ['id' => 3,'name' => 'Max', 'description' => 'Lorem ipsum dolor sit amet', 'available' => true],
        ];

        return array_map(function ($cat) {
            $dogsImage = $this->getDogsImage();
            $cat['image'] = $dogsImage[array_rand($dogsImage)]['url'];

            return $cat;
        }, $dogs);
    }

    // https://catfact.ninja/fact
    public function getCatsImage(): mixed
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

    public function getDogsImage(): array
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