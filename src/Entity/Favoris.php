<?php

namespace App\Entity;

use App\Repository\FavorisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavorisRepository::class)
 */
class Favoris
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="favoris", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=FavorisDetail::class, cascade={"persist"}, mappedBy="favoris", orphanRemoval=true)
     */
    private $favorisDetails;

    public function __construct()
    {
        $this->favorisDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|FavorisDetail[]
     */
    public function getFavorisDetails(): Collection
    {
        return $this->favorisDetails;
    }

    public function addFavorisDetail(FavorisDetail $favorisDetail): self
    {
        if (!$this->favorisDetails->contains($favorisDetail)) {
            $this->favorisDetails[] = $favorisDetail;
            $favorisDetail->setFavoris($this);
        }

        return $this;
    }

    public function removeFavorisDetail(FavorisDetail $favorisDetail): self
    {
        if ($this->favorisDetails->removeElement($favorisDetail)) {
            // set the owning side to null (unless already changed)
            if ($favorisDetail->getFavoris() === $this) {
                $favorisDetail->setFavoris(null);
            }
        }

        return $this;
    }
}
