<?php

namespace App\Entity;

use App\Repository\BoardGameMarketRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoardGameMarketRepository::class)
 */
class BoardGameMarket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=BoardGame::class, inversedBy="boardGameMarkets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $boardGame;

    /**
     * @ORM\ManyToOne(targetEntity=Market::class, inversedBy="boardGameMarkets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $market;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoardGame(): ?BoardGame
    {
        return $this->boardGame;
    }

    public function setBoardGame(?BoardGame $boardGame): self
    {
        $this->boardGame = $boardGame;

        return $this;
    }

    public function getMarket(): ?Market
    {
        return $this->market;
    }

    public function setMarket(?Market $market): self
    {
        $this->market = $market;

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
}
