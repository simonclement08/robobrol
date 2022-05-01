<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
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
     * @ORM\OneToMany(targetEntity=BoardGameType::class, mappedBy="type", orphanRemoval=true)
     */
    private $boardGameTypes;

    public function __construct()
    {
        $this->boardGameTypes = new ArrayCollection();
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
     * @return Collection<int, BoardGameType>
     */
    public function getBoardGameTypes(): Collection
    {
        return $this->boardGameTypes;
    }

    public function addBoardGameType(BoardGameType $boardGameType): self
    {
        if (!$this->boardGameTypes->contains($boardGameType)) {
            $this->boardGameTypes[] = $boardGameType;
            $boardGameType->setType($this);
        }

        return $this;
    }

    public function removeBoardGameType(BoardGameType $boardGameType): self
    {
        if ($this->boardGameTypes->removeElement($boardGameType)) {
            // set the owning side to null (unless already changed)
            if ($boardGameType->getType() === $this) {
                $boardGameType->setType(null);
            }
        }

        return $this;
    }
}
