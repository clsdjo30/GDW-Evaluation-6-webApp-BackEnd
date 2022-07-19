<?php

namespace App\Entity;

use App\Repository\TargetRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: TargetRepository::class)]
class Target implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 30,
        minMessage: 'Le prénom de la cible doit contenir au moins 5 caractères',
        maxMessage: 'le prénom de la cible est trop long')]
    private ?string $firstname;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 30,
        minMessage: 'Le nom de la cible doit contenir au moins 5 caractères',
        maxMessage: 'le nom de la cible est trop long')]
    private ?string $lastname;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $birthday;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 30,
        minMessage: 'Le nom de code de la cible doit contenir au moins 5 caractères',
        maxMessage: 'le nom de code de la cible est trop long')]
    private ?string $code_name;

    #[ORM\ManyToOne(
        targetEntity: Country::class,
        inversedBy: 'targets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private ?Country $country;

    #[ORM\ManyToOne(
        targetEntity: Mission::class,
        inversedBy: 'targets')]
    #[ORM\JoinColumn(nullable: true)]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private ?Mission $mission_id;

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

    public function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

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

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getMissionId(): ?Mission
    {
        return $this->mission_id;
    }

    public function setMissionId(?Mission $mission_id): self
    {
        $this->mission_id = $mission_id;

        return $this;
    }

    public function __toString(): string
    {
        return $this->firstname . ' ' . $this->lastname . '  Pays : ' . $this->country . ' - Nom de  Code : ' . $this->code_name;
    }
}
