<?php

namespace App\DTO;

class RocketDTO
{
    public array $height;
    public array $diameter;
    public array $mass;
    public array $firstStage;
    public array $secondStage;
    public array $engines;
    public array $landingLegs;
    public array $payloadWeights;
    public array $flickrImages;
    public string $name;
    public string $type;
    public bool $active;
    public int $stages;
    public int $boosters;
    public int $costPerLaunch;
    public int $successRatePct;
    public string $firstFlight;
    public string $country;
    public string $company;
    public string $wikipedia;
    public string $description;
    public string $id;

    public function __construct(array $data) {
        $this->height = $data['height'];
        $this->diameter = $data['diameter'];
        $this->mass = $data['mass'];
        $this->firstStage = $data['first_stage'];
        $this->secondStage = $data['second_stage'];
        $this->engines = $data['engines'];
        $this->landingLegs = $data['landing_legs'];
        $this->payloadWeights = $data['payload_weights'];
        $this->flickrImages = $data['flickr_images'];
        $this->name = $data['name'];
        $this->type = $data['type'];
        $this->active = $data['active'];
        $this->stages = $data['stages'];
        $this->boosters = $data['boosters'];
        $this->costPerLaunch = $data['cost_per_launch'];
        $this->successRatePct = $data['success_rate_pct'];
        $this->firstFlight = $data['first_flight'];
        $this->country = $data['country'];
        $this->company = $data['company'];
        $this->wikipedia = $data['wikipedia'];
        $this->description = $data['description'];
        $this->id = $data['id'];
    }
}
