<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id ;

    #[ORM\Column(length: 255)]
   /**
     * @Assert\NotBlank(message="type  doit etre non vide")
     * @Assert\Length(
     *      min = 5,
     *      max = 100,
     *      minMessage = "doit etre >=7 ",
     *      maxMessage = "doit etre <=100" )
     * @ORM\Column(type="string", length=1000)
     */
    private ?string $type ;

   
    #[ORM\Column(length: 255)]
     /**
     * @Assert\NotBlank(message="nom   :doit etre non vide")
     * @Assert\Length(
     *      min = 4,
     *       minMessage="Enter un nom de 4 caracteres au minimum"
     * )
     * @ORM\Column(type="string", length=1000)
     */
    private ?string $nom ;

    #[ORM\Column(length: 255)]
     /**
     * @Assert\NotBlank(message="description  doit etre non vide")
     * @Assert\Length(
     *      min = 7,
     *      max = 100,
     *      minMessage = "doit etre >=7 ",
     *      maxMessage = "doit etre <=100" )
     * @ORM\Column(type="string", length=1000)
     */
    private ?string $description ;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datet_reclama;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Remboursement $remboursement = null;

       
  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDatetReclama(): ?\DateTimeInterface
    {
        return $this->datet_reclama;
    }

    public function setDatetReclama(\DateTimeInterface $datet_reclama): static
    {
        $this->datet_reclama = $datet_reclama;

        return $this;
    }

    public function getRemboursement(): ?Remboursement
    {
        return $this->remboursement;
    }

    public function setRemboursement(?Remboursement $remboursement): static
    {
        $this->remboursement = $remboursement;

        return $this;
    }
}
