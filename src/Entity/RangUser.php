<?php

namespace App\Entity;

use App\Repository\RangUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RangUserRepository::class)
 */
class RangUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="rangUser")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $condition_obtention;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id[] = $userId;
            $userId->setRangUser($this);
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        if ($this->user_id->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getRangUser() === $this) {
                $userId->setRangUser(null);
            }
        }

        return $this;
    }

    public function getConditionObtention(): ?string
    {
        return $this->condition_obtention;
    }

    public function setConditionObtention(string $condition_obtention): self
    {
        $this->condition_obtention = $condition_obtention;

        return $this;
    }
}
