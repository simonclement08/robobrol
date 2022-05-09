<?php

namespace App\Entity;

use App\Repository\BoardGameWishRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoardGameWishRepository::class)
 */
class BoardGameWish
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=BoardGame::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $boardGame;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="boardGameWishes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
