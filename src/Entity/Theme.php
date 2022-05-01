<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 */
class Theme
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
     * @ORM\OneToMany(targetEntity=BoardGameTheme::class, mappedBy="theme", orphanRemoval=true)
     */
    private $boardGameThemes;

    public function __construct()
    {
        $this->boardGameThemes = new ArrayCollection();
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
     * @return Collection<int, BoardGameTheme>
     */
    public function getBoardGameThemes(): Collection
    {
        return $this->boardGameThemes;
    }

    public function addBoardGameTheme(BoardGameTheme $boardGameTheme): self
    {
        if (!$this->boardGameThemes->contains($boardGameTheme)) {
            $this->boardGameThemes[] = $boardGameTheme;
            $boardGameTheme->setTheme($this);
        }

        return $this;
    }

    public function removeBoardGameTheme(BoardGameTheme $boardGameTheme): self
    {
        if ($this->boardGameThemes->removeElement($boardGameTheme)) {
            // set the owning side to null (unless already changed)
            if ($boardGameTheme->getTheme() === $this) {
                $boardGameTheme->setTheme(null);
            }
        }

        return $this;
    }
}
