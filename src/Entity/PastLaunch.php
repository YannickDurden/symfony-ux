<?php

namespace App\Entity;

use App\Repository\PastLaunchRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PastLaunchRepository::class)]
class PastLaunch
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $details = null;

    #[ORM\Column]
    private ?bool $success = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $patch = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $launchDate = null;

    #[ORM\ManyToOne(inversedBy: 'pastLaunches')]
    private ?Rocket $rocket = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function isSuccess(): ?bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): static
    {
        $this->success = $success;

        return $this;
    }

    public function getPatch(): ?string
    {
        return $this->patch;
    }

    public function setPatch(?string $patch): static
    {
        $this->patch = $patch;

        return $this;
    }

    public function getLaunchDate(): ?\DateTimeInterface
    {
        return $this->launchDate;
    }

    public function setLaunchDate(?\DateTimeInterface $launchDate): static
    {
        $this->launchDate = $launchDate;

        return $this;
    }

    public function getRocket(): ?Rocket
    {
        return $this->rocket;
    }

    public function setRocket(?Rocket $rocket): static
    {
        $this->rocket = $rocket;

        return $this;
    }
}
