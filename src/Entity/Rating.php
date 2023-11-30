<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $rating = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    private ?Bonplan $bonplan = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getBonplan(): ?Bonplan
    {
        return $this->bonplan;
    }

    public function setBonplan(?Bonplan $bonplan): static
    {
        $this->bonplan = $bonplan;
        if ($bonplan !== null) {
            $bonplan->updateRating();
        }

        return $this;
    }



}
