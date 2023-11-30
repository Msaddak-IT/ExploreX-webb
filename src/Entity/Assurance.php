<?php

namespace App\Entity;

use App\Repository\AssuranceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: AssuranceRepository::class)]
class Assurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idUser = null;

    #[ORM\Column]
    private ?int $idCategorie = null;

    #[ORM\Column]
    private ?int $idAgence = null;

    #[ORM\Column]
    /**
     * @Assert\NotBlank(message=" titre doit etre non vide")
     * @Assert\Length(
     *      min = 5,
     *      minMessage=" Entrer un titre au mini de 5 caracteres"
     *
     *     )
     * @ORM\Column(type="string", length=255)
     */
    private ?int $passeport = null;

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
    private ?string $destination = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'assurance', targetEntity: Agence::class)]
    private Collection $idagence;

    #[ORM\OneToMany(mappedBy: 'assurances', targetEntity: Categorie::class)]
    private Collection $categories;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $QrCode = null;


    public function __construct()
    {
        $this->idagence = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(int $idCategorie): static
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function getIdAgence(): ?int
    {
        return $this->idAgence;
    }

    public function setIdAgence(int $idAgence): static
    {
        $this->idAgence = $idAgence;

        return $this;
    }

    public function getPasseport(): ?int
    {
        return $this->passeport;
    }

    public function setPasseport(int $passeport): static
    {
        $this->passeport = $passeport;

        return $this;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function addIdagence(agence $idagence): static
    {
        if (!$this->idagence->contains($idagence)) {
            $this->idagence->add($idagence);
            $idagence->setAssurance($this);
        }

        return $this;
    }

    public function removeIdagence(agence $idagence): static
    {
        if ($this->idagence->removeElement($idagence)) {
            // set the owning side to null (unless already changed)
            if ($idagence->getAssurance() === $this) {
                $idagence->setAssurance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setAssurances($this);
        }

        return $this;
    }

    public function removeCategory(categorie $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getAssurances() === $this) {
                $category->setAssurances(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->id;
    }
    public function getQrcode(): string
    {
        return $this->qrcode;
    }

    /**
     * @param string $qrcode
     */
    public function setQrcode(string $qrcode): void
    {
        $this->qrcode = $qrcode;
    }
}
