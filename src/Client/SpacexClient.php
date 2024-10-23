<?php

namespace App\Client;

use App\DTO\LaunchDTO;
use App\DTO\RocketDTO;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

readonly class SpacexClient
{
    private const string ROCKET = 'v4/rockets/%s';
    private const string ALL_ROCKETS = '/v4/rockets';
    private const string LAUNCHES_LATEST = 'v4/launches/latest';
    private const string LAUNCHES_PAST = 'v4/launches/query';

    public function __construct(
        private HttpClientInterface $spacexClient,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function request(string $url, string $method = 'GET', array $options = []): ResponseInterface
    {
       return $this->spacexClient->request($method, $url, $options);
    }

    /**
     * @return array<RocketDTO>
     * @throws TransportExceptionInterface
     */
    public function fetchRockets(): array
    {
        $req = $this->request(self::ALL_ROCKETS);
        $content = $req->toArray();

        if (empty($content)) {
            return [];
        }

        $rockets = [];
        foreach ($content as $rocket) {
            $rocketDto = new RocketDTO($rocket);
            $rockets[] = $rocketDto;
        }

        return $rockets;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function fetchRocketById(string $id): ?RocketDTO
    {
        $req = $this->request(sprintf(self::ROCKET, $id));
        $content = $req->toArray();

        if (empty($content)) {
            return null;
        }

        return new RocketDTO($content);
    }

    /**
     * @return array<LaunchDTO>
     * @throws TransportExceptionInterface
     */
    public function fetchPastLaunches(int $limit = 5): array
    {
        $payload = [
            'query' => [
                'upcoming' => false,
            ],
            'options' => [
                'limit' => $limit,
                'sort' => [
                    'flight_number' => 'asc',
                ]
            ]
        ];

        $req = $this->request(
            url: self::LAUNCHES_PAST,
            method: 'POST',
            options: [
                'json' => $payload
            ]
        );

        $content = $req->toArray();

        if (empty($content)) {
            return [];
        }

        $pastLaunches = [];

        foreach ($content['docs'] as $launch) {
            $pastLaunches[] = new LaunchDTO($launch);
        }

        return $pastLaunches;
    }
}
