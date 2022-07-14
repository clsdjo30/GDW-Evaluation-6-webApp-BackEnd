<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Mission::class, orphanRemoval: true)]
    private Collection $mission_types;

    public function __construct()
    {
        $this->mission_types = new ArrayCollection();
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

    /**
     * @return Collection<int, Mission>
     */
    public function getMissionTypes(): Collection
    {
        return $this->mission_types;
    }

    public function addMissionType(Mission $missionType): self
    {
        if (!$this->mission_types->contains($missionType)) {
            $this->mission_types[] = $missionType;
            $missionType->setType($this);
        }

        return $this;
    }

    public function removeMissionType(Mission $missionType): self
    {
        if ($this->mission_types->removeElement($missionType)) {
            // set the owning side to null (unless already changed)
            if ($missionType->getType() === $this) {
                $missionType->setType(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
