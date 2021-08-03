<?php

namespace App\Entity;

use App\Repository\CollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CollectionRepository::class)
 */
class Collection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     *     message="Ce champs ne peut pas ête vide"
     * )
     * @Assert\Positive(
     *     message="La référence ne peut pas être négative"
     * )
     * @Assert\Positive(
     *     message="La référence ne peut pas être négative"
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     message="La référence ne doit contenir que des chiffres"
     * )
     */
    private $referenceNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="Ce champs ne peut pas ête vide"
     * )
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="Ce nom est trop court",
     *     maxMessage="Ce nom est trop long"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     *     message="Ce champs ne peut pas ête vide"
     * )
     * @Assert\Positive(
     *     message="Le nombre de pièces ne peut pas être négatif"
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     message="Le nombre de pièces ne doit contenir que des chiffres"
     * )
     */
    private $numberPieces;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $depth;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $addedAt;

    /**
     * @ORM\OneToMany(targetEntity=UserCollection::class, mappedBy="collection", orphanRemoval=true)
     */
    private $userCollections;

    public function __construct()
    {
        $this->userCollections = new ArrayCollection();
    }

    public function getId()
    : ?int
    {
        return $this->id;
    }

    public function getReferenceNumber()
    : ?int
    {
        return $this->referenceNumber;
    }

    public function setReferenceNumber(int $referenceNumber)
    : self {
        $this->referenceNumber = $referenceNumber;

        return $this;
    }

    public function getName()
    : ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    : self {
        $this->name = $name;

        return $this;
    }

    public function getNumberPieces()
    : ?int
    {
        return $this->numberPieces;
    }

    public function setNumberPieces(int $numberPieces)
    : self {
        $this->numberPieces = $numberPieces;

        return $this;
    }

    public function getHeight()
    : ?int
    {
        return $this->height;
    }

    public function setHeight(int $height)
    : self {
        $this->height = $height;

        return $this;
    }

    public function getWidth()
    : ?int
    {
        return $this->width;
    }

    public function setWidth(int $width)
    : self {
        $this->width = $width;

        return $this;
    }

    public function getDepth()
    : ?int
    {
        return $this->depth;
    }

    public function setDepth(int $depth)
    : self {
        $this->depth = $depth;

        return $this;
    }

    public function getAddedAt()
    : ?\DateTimeImmutable
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeImmutable $addedAt)
    : self {
        $this->addedAt = $addedAt;

        return $this;
    }

    /**
     * @return Collection|UserCollection[]
     */
    public function getUserCollections()
    : Collection
    {
        return $this->userCollections;
    }

    public function addUserCollection(UserCollection $userCollection)
    : self {
        if (!$this->userCollections->contains($userCollection)) {
            $this->userCollections[] = $userCollection;
            $userCollection->setCollection($this);
        }

        return $this;
    }

    public function removeUserCollection(UserCollection $userCollection)
    : self {
        if ($this->userCollections->removeElement($userCollection)) {
            // set the owning side to null (unless already changed)
            if ($userCollection->getCollection() === $this) {
                $userCollection->setCollection(null);
            }
        }

        return $this;
    }
}
