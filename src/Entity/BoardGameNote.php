<?php

namespace App\Entity;

use App\Repository\BoardGameNoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoardGameNoteRepository::class)
 */
class BoardGameNote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=BoardGame::class, inversedBy="boardGameNotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $boardGame;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="boardGameNotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

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

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

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
