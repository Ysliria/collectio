<?php

namespace App\Entity;

use App\Repository\UserCollectionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserCollectionRepository::class)
 */
class UserCollection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userCollections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Collection::class, inversedBy="userCollections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $collection;

    /**
     * @ORM\Column(type="boolean")
     */
    private $favourite;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCollection(): ?Collection
    {
        return $this->collection;
    }

    public function setCollection(?Collection $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function getFavourite(): ?bool
    {
        return $this->favourite;
    }

    public function setFavourite(bool $favourite): self
    {
        $this->favourite = $favourite;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
