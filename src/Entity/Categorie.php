<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /**
     * @Assert\NotBlank(message=" titre doit etre non vide")
     * @Assert\Length(
     *      min = 5,
     *      minMessage=" Entrer un titre au mini de 5 caracteres"
     *
     *     )
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nomCategorie = null;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    private ?Assurance $assurances = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?assurance $assurancee = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString() : string
    {
        return $this->nomCategorie;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): static
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    public function getAssurances(): ?Assurance
    {
        return $this->assurances;
    }

    public function setAssurances(?Assurance $assurances): static
    {
        $this->assurances = $assurances;

        return $this;
    }

    public function getAssurancee(): ?assurance
    {
        return $this->assurancee;
    }

    public function setAssurancee(?assurance $assurancee): static
    {
        $this->assurancee = $assurancee;

        return $this;
    }
}
