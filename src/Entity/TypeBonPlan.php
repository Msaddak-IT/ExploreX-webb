<?php

namespace App\Entity;

use App\Repository\TypeBonPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeBonPlanRepository::class)]
class TypeBonPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomTypeBonPlan = null;

    #[ORM\OneToMany(mappedBy: 'typeBonPlan', targetEntity: Bonplan::class)]
    private Collection $bonplans;

    public function __construct()
    {
        $this->bonplans = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->nomTypeBonPlan ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeBonPlan(): ?string
    {
        return $this->nomTypeBonPlan;
    }

    public function setNomTypeBonPlan(string $nomTypeBonPlan): static
    {
        $this->nomTypeBonPlan = $nomTypeBonPlan;

        return $this;
    }

    /**
     * @return Collection<int, Bonplan>
     */
    public function getBonplans(): Collection
    {
        return $this->bonplans;
    }

    public function addBonplan(Bonplan $bonplan): static
    {
        if (!$this->bonplans->contains($bonplan)) {
            $this->bonplans->add($bonplan);
            $bonplan->setTypeBonPlan($this);
        }

        return $this;
    }

    public function removeBonplan(Bonplan $bonplan): static
    {
        if ($this->bonplans->removeElement($bonplan)) {
            // set the owning side to null (unless already changed)
            if ($bonplan->getTypeBonPlan() === $this) {
                $bonplan->setTypeBonPlan(null);
            }
        }

        return $this;
    }
}
