<?php

namespace App\Entity;

use App\Repository\BonplanRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Expression;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BonplanRepository::class)]
class Bonplan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameBonPlan = null;

    #[ORM\Column]
    #[Assert\LessThan(5,message: "tha ratiung must not be more than 5.0")]
    private ?float $rating = null;

    #[Assert\Expression(
        expression:
        'this.getStartDate()<this.getEndDate() ',message:'the start date must be smaller than the end date.'
    )]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[Assert\Expression(
        expression:
        'this.getStartDate()<this.getEndDate() ',message:'the end date must be greater than the start date.'
    )]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column]
    private ?float $avgPrice = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\ManyToOne(inversedBy: 'bonplans')]
    private ?TypeBonPlan $typeBonPlan = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameBonPlan(): ?string
    {
        return $this->nameBonPlan;
    }

    public function setNameBonPlan(string $nameBonPlan): static
    {
        $this->nameBonPlan = $nameBonPlan;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getAvgPrice(): ?float
    {
        return $this->avgPrice;
    }

    public function setAvgPrice(float $avgPrice): static
    {
        $this->avgPrice = $avgPrice;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getTypeBonPlan(): ?TypeBonPlan
    {
        return $this->typeBonPlan;
    }

    public function setTypeBonPlan(?TypeBonPlan $typeBonPlan): static
    {
        $this->typeBonPlan = $typeBonPlan;

        return $this;
    }
}
