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

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Target::class)]
    private Collection $targets;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Contact::class)]
    private Collection $contacts;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Agent::class)]
    private Collection $agents;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Hideout::class)]
    private Collection $hideouts;


    public function __construct()
    {
        $this->mission_country = new ArrayCollection();
        $this->targets = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->agents = new ArrayCollection();
        $this->hideouts = new ArrayCollection();
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
            $target->setCountry($this);
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        if ($this->targets->removeElement($target)) {
            // set the owning side to null (unless already changed)
            if ($target->getCountry() === $this) {
                $target->setCountry(null);
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
            $contact->setCountry($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getCountry() === $this) {
                $contact->setCountry(null);
            }
        }

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
            $agent->setCountry($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getCountry() === $this) {
                $agent->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hideout>
     */
    public function getHideouts(): Collection
    {
        return $this->hideouts;
    }

    public function addHideout(Hideout $hideout): self
    {
        if (!$this->hideouts->contains($hideout)) {
            $this->hideouts[] = $hideout;
            $hideout->setCountry($this);
        }

        return $this;
    }

    public function removeHideout(Hideout $hideout): self
    {
        if ($this->hideouts->removeElement($hideout)) {
            // set the owning side to null (unless already changed)
            if ($hideout->getCountry() === $this) {
                $hideout->setCountry(null);
            }
        }

        return $this;
    }

}
