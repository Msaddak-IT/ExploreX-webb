<?php

namespace App\Entity;

use App\Repository\RemboursementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RemboursementRepository::class)]
class Remboursement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montant_rembour = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_rembour = null;

    #[ORM\Column]
    private ?int $id_rec = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Reclamation $reclamation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantRembour(): ?int
    {
        return $this->montant_rembour;
    }

    public function setMontantRembour(int $montant_rembour): static
    {
        $this->montant_rembour = $montant_rembour;

        return $this;
    }

    public function getDateRembour(): ?\DateTimeInterface
    {
        return $this->date_rembour;
    }

    public function setDateRembour(\DateTimeInterface $date_rembour): static
    {
        $this->date_rembour = $date_rembour;

        return $this;
    }

    public function getIdRec(): ?int
    {
        return $this->id_rec;
    }

    public function setIdRec(int $id_rec): static
    {
        $this->id_rec = $id_rec;

        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): static
    {
        $this->reclamation = $reclamation;

        return $this;
    }
}
