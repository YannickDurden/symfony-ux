<?php

namespace App\Entity;

use App\Repository\RocketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RocketRepository::class)]
class Rocket
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $height = null;

    #[ORM\Column]
    private ?float $mass = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 255)]
    private ?string $apiId = null;

    /**
     * @var Collection<int, PastLaunch>
     */
    #[ORM\OneToMany(targetEntity: PastLaunch::class, mappedBy: 'rocket')]
    private Collection $pastLaunches;

    public function __construct()
    {
        $this->pastLaunches = new ArrayCollection();
    }

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getMass(): ?float
    {
        return $this->mass;
    }

    public function setMass(float $mass): static
    {
        $this->mass = $mass;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getApiId(): ?string
    {
        return $this->apiId;
    }

    public function setApiId(string $apiId): static
    {
        $this->apiId = $apiId;

        return $this;
    }

    /**
     * @return Collection<int, PastLaunch>
     */
    public function getPastLaunches(): Collection
    {
        return $this->pastLaunches;
    }

    public function addPastLaunch(PastLaunch $pastLaunch): static
    {
        if (!$this->pastLaunches->contains($pastLaunch)) {
            $this->pastLaunches->add($pastLaunch);
            $pastLaunch->setRocket($this);
        }

        return $this;
    }

    public function removePastLaunch(PastLaunch $pastLaunch): static
    {
        if ($this->pastLaunches->removeElement($pastLaunch)) {
            // set the owning side to null (unless already changed)
            if ($pastLaunch->getRocket() === $this) {
                $pastLaunch->setRocket(null);
            }
        }

        return $this;
    }
}
