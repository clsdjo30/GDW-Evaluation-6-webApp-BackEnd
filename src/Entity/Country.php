<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5)]
    private ?string $nationality;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Mission::class, orphanRemoval: true)]
    private Collection $mission_country;

    public function __construct()
    {
        $this->mission_country = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissionCountry(): Collection
    {
        return $this->mission_country;
    }

    public function addMissionCountry(Mission $missionCountry): self
    {
        if (!$this->mission_country->contains($missionCountry)) {
            $this->mission_country[] = $missionCountry;
            $missionCountry->setCountry($this);
        }

        return $this;
    }

    public function removeMissionCountry(Mission $missionCountry): self
    {
        if ($this->mission_country->removeElement($missionCountry)) {
            // set the owning side to null (unless already changed)
            if ($missionCountry->getCountry() === $this) {
                $missionCountry->setCountry(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}