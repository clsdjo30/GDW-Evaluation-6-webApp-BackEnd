<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5)]
    private ?string $name;

    #[ORM\OneToMany(
        mappedBy: 'type',
        targetEntity: Mission::class,
        orphanRemoval: true)]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private Collection $mission_types;

    #[ORM\ManyToMany(
        targetEntity: Agent::class,
        mappedBy: 'skills')]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private Collection $agents;

    public function __construct()
    {
        $this->mission_types = new ArrayCollection();
        $this->agents = new ArrayCollection();
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

    /**
     * @return Collection<int, Agent>
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
            $agent->addSkill($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            $agent->removeSkill($this);
        }

        return $this;
    }
}
