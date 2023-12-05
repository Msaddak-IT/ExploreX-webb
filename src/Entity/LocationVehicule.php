<?php

namespace App\Entity;

use App\Repository\LocationVehiculeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationVehiculeRepository::class)]
class LocationVehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_loc_vehicule = null;

    #[ORM\Column]
    private ?int $cin_client_vehicule = null;

    #[ORM\Column(length: 100)]
    private ?string $duree_loc_vehicule = null;

    #[ORM\Column(length: 100)]
    private ?string $pickup_vehicule = null;

    #[ORM\Column(length: 100)]
    private ?string $return_vehicule = null;

    #[ORM\Column]
    private ?int $montantLocation = null;

    #[ORM\ManyToOne(targetEntity: Vehicule::class, inversedBy: 'locationVehicules')]
    #[ORM\JoinColumn(name: "matriculeVehicule", referencedColumnName: "matricule", nullable: true)]
    private ?vehicule $vehicules = null;

    public function getIdlocvehicule(): ?int
    {
        return $this->id_loc_vehicule;
    }

    public function getCinclientvehicule(): ?int
    {
        return $this->cin_client_vehicule;
    }

    public function setCinclientvehicule(int $cin_client_vehicule): static
    {
        $this->cin_client_vehicule = $cin_client_vehicule;

        return $this;
    }

    public function getDureelocvehicule(): ?string
    {
        return $this->duree_loc_vehicule;
    }

    public function setDureelocvehicule(string $duree_loc_vehicule): static
    {
        $this->duree_loc_vehicule = $duree_loc_vehicule;

        return $this;
    }

    public function getPickupvehicule(): ?\DateTimeInterface
    {
        return $this->pickup_vehicule ? new \DateTime($this->pickup_vehicule) : null;
    }

    public function setPickupvehicule(?\DateTimeInterface $pickup_vehicule): self
    {
        $this->pickup_vehicule = $pickup_vehicule ? $pickup_vehicule->format('Y-m-d') : null;

        return $this;
    }

    public function getReturnvehicule(): ?\DateTimeInterface
    {
        return $this->return_vehicule? new \DateTime($this->return_vehicule) : null;
    }

    public function setReturnvehicule(?\DateTimeInterface $return_vehicule): self
    {
        $this->return_vehicule = $return_vehicule ? $return_vehicule->format('Y-m-d') : null;

        return $this;
    }

    public function getMontantLocation(): ?int
    {
        return $this->montantLocation;
    }

    public function setMontantLocation(int $montantLocation): static
    {
        $this->montantLocation = $montantLocation;

        return $this;
    }

    public function getVehicules(): ?vehicule
    {
        return $this->vehicules;
    }

    public function setVehicules(?vehicule $vehicules): static
    {
        $this->vehicules = $vehicules;

        return $this;
    }
}
