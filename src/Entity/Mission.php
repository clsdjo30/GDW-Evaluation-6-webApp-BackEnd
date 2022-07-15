<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
class Mission
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

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $startAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $endAt;

    #[ORM\ManyToOne(targetEntity: Country::class, cascade: ['persist', 'remove'], inversedBy: 'mission_country')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country;

    #[ORM\ManyToOne(targetEntity: Skill::class, cascade: ['persist', 'remove'], inversedBy: 'mission_types')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Skill $type;

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

    public function getStartAt(): ?DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(?DateTimeImmutable $endAt): self
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
}
