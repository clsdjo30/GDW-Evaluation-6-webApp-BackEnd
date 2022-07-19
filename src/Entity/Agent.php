<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
class Agent implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 30,
        minMessage: "Le prénom de l'agent doit contenir au moins 5 caractères",
        maxMessage: "le prénom de l'agent est trop long")]
    private ?string $firstname;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 30,
        minMessage: "Le nom de l'agent doit contenir au moins 5 caractères",
        maxMessage: "le nom de l'agent est trop long")]
    private ?string $lastname;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 30,
        minMessage: "Le nom de code de l'agent doit contenir au moins 5 caractères",
        maxMessage: "le nom de code de l'agent est trop long")]
    private ?string $code_name;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $birthday;

    #[ORM\ManyToOne(
        targetEntity: Country::class,
        inversedBy: 'agents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private ?Country $country;

    #[ORM\ManyToOne(
        targetEntity: Mission::class,
        cascade: ['persist', 'remove'],
        inversedBy: 'agents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mission $mission;

    #[ORM\ManyToMany(
        targetEntity: Skill::class,
        inversedBy: 'agents',
        cascade: ['persist', 'remove'])]
    private Collection $skills;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCodeName(): ?string
    {
        return $this->code_name;
    }

    public function setCodeName(string $code_name): self
    {
        $this->code_name = $code_name;

        return $this;
    }

    public function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    public function setMission(?Mission $mission): self
    {
        $this->mission = $mission;

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    public function showSkills(): array
    {
        $agentSkills = $this->skills;
        $listSkills = [];

        foreach ($agentSkills as $agentSkill) {
            $listSkills[] = $agentSkill->getName();
        }
        return $listSkills;
    }

    public function __toString(): string
    {
        $skills = $this->showSkills();

        return 'Pays : ' . $this->country . ' - Agent : ' . $this->getFullname() . ' - Specialités : ' . implode(', ', $skills);
    }

    public function getFullname(): string
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }
}
