<?php

namespace App\Entity;
use App\Entity\Service;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OffresRepository;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass:OffresRepository::class)]
class Offres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ? int $idOffres=null;

    #[ORM\Column(length:110)]
    private ? string  $destination=null;

    #[ORM\Column(name: "debut", type: "date", nullable: true)]
    /*
    private \DateTime $debut;
    */
    
    private ? \DateTimeInterface $debut = null;


    #[ORM\Column(name: "fin", type: "date", nullable: true)]
    /*
    private \DateTime $fin;
    */

    private ? \DateTimeInterface $fin = null;

#[ORM\Column]
private? int $prix=null;


#[ORM\ManyToOne(targetEntity: Service::class)]
#[ORM\JoinColumn(name: 'service', referencedColumnName: 'id_service')]

private ?Service $service;






    public function getIdOffres(): ?int
    {
        return $this->idOffres;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): static
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): static
    {
        $this->fin = $fin;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

  

    

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    
    }















