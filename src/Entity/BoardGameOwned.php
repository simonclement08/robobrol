<?php

namespace App\Entity;

use App\Repository\BoardGameOwnedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoardGameOwnedRepository::class)
 */
class BoardGameOwned
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="boardGameOwneds")
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
