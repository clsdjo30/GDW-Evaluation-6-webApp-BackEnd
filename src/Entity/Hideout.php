<?php

namespace App\Entity;

use App\Repository\HideoutRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: HideoutRepository::class)]
class Hideout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Assert\Type("string")]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 30,
        minMessage: 'Le code doit contenir au moins 5 caractères',
        maxMessage: 'le code est trop long')]
    private ?string $code;

    #[ORM\Column(length: 255)]
    #[Assert\Type("string")]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 150,
        minMessage: "L'adresse doit contenir au moins 5 caractères",
        maxMessage: "l'adresse est trop longue")]
    private ?string $address;

    #[ORM\ManyToOne(
        targetEntity: Country::class,
        inversedBy: 'hideouts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private ?Country $country;

    #[ORM\ManyToOne(
        targetEntity: Mission::class,
        inversedBy: 'hideout')]
    #[Assert\Type("object")]
    #[Assert\NotBlank]
    private ?Mission $mission;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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
}
