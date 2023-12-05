<?php

namespace App\Entity;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Service;
#[ORM\Entity(repositoryClass:ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_service", type: "integer")]
    private ?int $idService;
   
   

    #[ORM\Column(length:110)]
    private ? string  $nomService=null;


    #[ORM\Column(length:110)]
    private ? string  $descriptionService=null;

    #[ORM\Column]
    private? int $prixService=null;
  
   

    public function getIdService(): ?int
    {
        return $this->idService;
    }

    public function getNomService(): ?string
    {
        return $this->nomService;
    }

    public function setNomService(string $nomService): static
    {
        $this->nomService = $nomService;

        return $this;
    }

    public function getDescriptionService(): ?string
    {
        return $this->descriptionService;
    }

    public function setDescriptionService(string $descriptionService): static
    {
        $this->descriptionService = $descriptionService;

        return $this;
    }

    public function getPrixService(): ?int
    {
        return $this->prixService;
    }

    public function setPrixService(int $prixService): static
    {
        $this->prixService = $prixService;

        return $this;
    }
    
    
    
    public function __toString()
    {
        return (string)$this->idService;
    }
}
    
