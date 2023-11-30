<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AgenceRepository::class)]
class Agence
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
    private ?string $nomAgence = null;

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
    private ?string $adresse = null;

    #[ORM\Column]
    private ?int $telephone = null;

    #[ORM\Column(length: 255)]

    /**
     * @Assert\Email(
     *     message = "L'adresse e-mail '{{ value }}' n'est pas valide.",
     * )
     */

    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'idagence')]
    private ?Assurance $assurance = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?assurance $assurances = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAgence(): ?string
    {
        return $this->nomAgence;
    }

    public function setNomAgence(string $nomAgence): static
    {
        $this->nomAgence = $nomAgence;

        return $this;
    }
    public function __toString() : string
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAssurance(): ?Assurance
    {
        return $this->assurance;
    }

    public function setAssurance(?Assurance $assurance): static
    {
        $this->assurance = $assurance;

        return $this;
    }

    public function getAssurances(): ?assurance
    {
        return $this->assurances;
    }

    public function setAssurances(?assurance $assurances): static
    {
        $this->assurances = $assurances;

        return $this;
    }
}
