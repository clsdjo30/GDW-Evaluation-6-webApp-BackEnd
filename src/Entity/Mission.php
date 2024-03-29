<?php

namespace App\Entity;


use App\Repository\MissionRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Stringable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
#[UniqueEntity(fields: ['slug'], errorPath: 'title', message: 'mission.slug_unique')]
class Mission implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Type("string")]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 30,
        minMessage: 'Le titre doit contenir au moins 5 caractères',
        maxMessage: 'le titre est trop long')]
    private ?string $title;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Type("string")]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 30,
        minMessage: "Le nom de code doit contenir au moins 5 caractères",
        maxMessage: "Le nom de code est trop long")]
    private ?string $code_name;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 1000,
        minMessage: 'La déscription doit contenir au moins 5 caractères',
        maxMessage: 'la déscription est trop longue')]
    private ?string $description;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $startAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $endAt;

    #[ORM\ManyToOne(
        targetEntity: Country::class,
        cascade: ['persist', 'remove'],
        inversedBy: 'mission_country')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private ?Country $country;

    #[ORM\ManyToOne(
        targetEntity: Skill::class,
        cascade: ['persist', 'remove'],
        inversedBy: 'mission_types')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private ?Skill $type;

    #[ORM\OneToMany(
        mappedBy: 'mission_id',
        targetEntity: Target::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true)]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private Collection $targets;

    #[ORM\ManyToMany(
        targetEntity: Contact::class,
        inversedBy: 'missions',
        cascade: ['persist', 'remove'])]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private Collection $contacts;

    #[ORM\OneToMany(
        mappedBy: 'mission',
        targetEntity: Agent::class,
        cascade: ['persist', 'remove'])]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private Collection $agents;

    #[ORM\OneToMany(
        mappedBy: 'mission',
        targetEntity: Hideout::class,
        cascade: ['persist', 'remove'])]
    #[Assert\Type("object")]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $hideout;

    #[ORM\ManyToOne(
        targetEntity: Statute::class,
        cascade: ['persist', 'remove'],
        inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private ?Statute $status;

    #[ORM\ManyToOne(
        targetEntity: User::class,
        cascade: ['persist', 'remove'],
        inversedBy: 'missions')]
    private ?User $user;

    #[ORM\Column(length: 255)]
    #[Slug(fields: ["title"])]
    private ?string $slug;

    public function __construct()
    {
        $this->targets = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->agents = new ArrayCollection();
        $this->hideout = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartAt(): ?DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

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

    public function getType(): ?Skill
    {
        return $this->type;
    }

    public function setType(?Skill $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    /**
     * @return Collection<int, Target>
     */
    public function getTargets(): Collection
    {
        return $this->targets;
    }

    public function addTarget(Target $target): self
    {
        if (!$this->targets->contains($target)) {
            $this->targets[] = $target;
            $target->setMissionId($this);
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        if ($this->targets->removeElement($target)) {
            // set the owning side to null (unless already changed)
            if ($target->getMissionId() === $this) {
                $target->setMissionId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        $this->contacts->removeElement($contact);

        return $this;
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
            $agent->setMission($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getMission() === $this) {
                $agent->setMission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hideout>
     */
    public function getHideout(): Collection
    {
        return $this->hideout;
    }

    public function addHideout(Hideout $hideout): self
    {
        if (!$this->hideout->contains($hideout)) {
            $this->hideout[] = $hideout;
            $hideout->setMission($this);
        }

        return $this;
    }

    public function removeHideout(Hideout $hideout): self
    {
        if ($this->hideout->removeElement($hideout)) {
            // set the owning side to null (unless already changed)
            if ($hideout->getMission() === $this) {
                $hideout->setMission(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?Statute
    {
        return $this->status;
    }

    public function setStatus(?Statute $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function contactAndMissionNationalityIsEqual(): bool
    {
        $missionCountry = $this->country;
        $nationalityContacts = $this->contacts;

        foreach ($nationalityContacts as $contact) {
            if ($missionCountry != $contact->getCountry()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function targetAndAgentAreDifferent(): bool
    {
        $targetNationality = $this->targets;
        $agentNationality = $this->agents;

        foreach ($targetNationality as $target) {
            foreach ($agentNationality as $agent) {
                if ($target->getCountry() === $agent->getCountry()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function agentHadMissionSkill(): bool
    {
        $missionSkill = $this->type;
        $skillAgents = $this->agents;

        $validSkill = 0;

        foreach ($skillAgents as $agent) {
            $agentSkills = $agent->showSkills();
            if (in_array($missionSkill->getName(), $agentSkills)) {
                $validSkill += 1;
            }
            if ($validSkill == 0) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function hideoutAndMissionCountryIsEqual(): bool
    {
        $missionCountry = $this->country;
        $hideoutCountry = $this->hideout;

        foreach ($hideoutCountry as $hideout) {
            if ($missionCountry !== $hideout->getCountry()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    #[ORM\PrePersist]
    public function missionIsValid(): bool
    {
        return !(!$this->contactAndMissionNationalityIsEqual() || !$this->targetAndAgentAreDifferent() || !$this->agentHadMissionSkill() || !$this->hideoutAndMissionCountryIsEqual());

    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}
