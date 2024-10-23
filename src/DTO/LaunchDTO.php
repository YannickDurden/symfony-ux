<?php

namespace App\DTO;

class LaunchDTO
{
    public ?array $fairings;
    public LinksDTO $links;
    public ?string $static_fire_date_utc;
    public ?int $static_fire_date_unix;
    public bool $net;
    public ?int $window;
    public string $rocket;
    public ?bool $success;
    public array $failures;
    public ?string $details;
    public array $crew;
    public array $ships;
    public array $capsules;
    public array $payloads;
    public string $launchpad;
    public int $flight_number;
    public string $name;
    public string $date_utc;
    public int $date_unix;
    public string $date_local;
    public string $date_precision;
    public bool $upcoming;
    public array $cores;
    public bool $auto_update;
    public bool $tbd;
    public ?string $launch_library_id;
    public string $id;

    public function __construct(array $data)
    {
        $this->fairings = $data['fairings'] ?? null;
        $this->links = new LinksDTO($data['links']);
        $this->static_fire_date_utc = $data['static_fire_date_utc'] ?? null;
        $this->static_fire_date_unix = $data['static_fire_date_unix'] ?? null;
        $this->net = $data['net'];
        $this->window = $data['window'] ?? null;
        $this->rocket = $data['rocket'];
        $this->success = $data['success'];
        $this->failures = $data['failures'] ?? [];
        $this->details = $data['details'] ?? null;
        $this->crew = $data['crew'] ?? [];
        $this->ships = $data['ships'] ?? [];
        $this->capsules = $data['capsules'] ?? [];
        $this->payloads = $data['payloads'] ?? [];
        $this->launchpad = $data['launchpad'];
        $this->flight_number = $data['flight_number'];
        $this->name = $data['name'];
        $this->date_utc = $data['date_utc'];
        $this->date_unix = $data['date_unix'];
        $this->date_local = $data['date_local'];
        $this->date_precision = $data['date_precision'];
        $this->upcoming = $data['upcoming'];
        $this->cores = array_map(static fn($core) => new CoreDTO($core), $data['cores']);
        $this->auto_update = $data['auto_update'];
        $this->tbd = $data['tbd'];
        $this->launch_library_id = $data['launch_library_id'] ?? null;
        $this->id = $data['id'];
    }
}
