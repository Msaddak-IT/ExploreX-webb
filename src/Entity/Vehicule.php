<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $matricule = null;

    #[ORM\Column(length: 50)]
    private ?string $type_vehicule = null;

    #[ORM\Column(length: 100)]
    private ?string $marque_vehicule = null;

    #[ORM\OneToMany(mappedBy: 'vehicules', targetEntity: LocationVehicule::class)]
    private Collection $locationVehicules;

    public function __construct()
    {
        $this->locationVehicules = new ArrayCollection();
    }

    // ... rest of your entity code

    public function getMatricule(): ?int
    {
        return $this->matricule;
    }
    public function setMatricule($matricule)
    {
        return $this->matricule = $matricule;
    }

    public function getTypeVehicule(): ?string
    {
        return $this->type_vehicule;
    }

    public function setTypeVehicule(string $type_vehicule): static
    {
        $this->type_vehicule = $type_vehicule;

        return $this;
    }

    public function getMarqueVehicule(): ?string
    {
        return $this->marque_vehicule;
    }

    public function setMarqueVehicule(string $marque_vehicule): static
    {
        $this->marque_vehicule = $marque_vehicule;

        return $this;
    }

    /**
     * @return Collection<int, LocationVehicule>
     */
    public function getLocationVehicules(): Collection
    {
        return $this->locationVehicules;
    }

    public function addLocationVehicule(LocationVehicule $locationVehicule): static
    {
        if (!$this->locationVehicules->contains($locationVehicule)) {
            $this->locationVehicules->add($locationVehicule);
            $locationVehicule->setVehicules($this);
        }

        return $this;
    }

    public function removeLocationVehicule(LocationVehicule $locationVehicule): static
    {
        if ($this->locationVehicules->removeElement($locationVehicule)) {
            // set the owning side to null (unless already changed)
            if ($locationVehicule->getVehicules() === $this) {
                $locationVehicule->setVehicules(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        // Vous pouvez ajuster cela en fonction des propriétés que vous souhaitez afficher
        return $this->matricule ?? '';
    }
}
