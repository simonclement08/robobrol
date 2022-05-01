<?php

namespace App\Entity;

use App\Repository\MarketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarketRepository::class)
 */
class Market
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
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\OneToMany(targetEntity=BoardGameMarket::class, mappedBy="market", orphanRemoval=true)
     */
    private $boardGameMarkets;

    public function __construct()
    {
        $this->boardGameMarkets = new ArrayCollection();
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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Collection<int, BoardGameMarket>
     */
    public function getBoardGameMarkets(): Collection
    {
        return $this->boardGameMarkets;
    }

    public function addBoardGameMarket(BoardGameMarket $boardGameMarket): self
    {
        if (!$this->boardGameMarkets->contains($boardGameMarket)) {
            $this->boardGameMarkets[] = $boardGameMarket;
            $boardGameMarket->setMarket($this);
        }

        return $this;
    }

    public function removeBoardGameMarket(BoardGameMarket $boardGameMarket): self
    {
        if ($this->boardGameMarkets->removeElement($boardGameMarket)) {
            // set the owning side to null (unless already changed)
            if ($boardGameMarket->getMarket() === $this) {
                $boardGameMarket->setMarket(null);
            }
        }

        return $this;
    }
}
