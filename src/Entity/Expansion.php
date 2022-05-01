<?php

namespace App\Entity;

use App\Repository\ExpansionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpansionRepository::class)
 */
class Expansion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=BoardGame::class, inversedBy="expansions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainGame;

    /**
     * @ORM\OneToOne(targetEntity=BoardGame::class, inversedBy="expansion", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $expansion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDependant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainGame(): ?BoardGame
    {
        return $this->mainGame;
    }

    public function setMainGame(?BoardGame $mainGame): self
    {
        $this->mainGame = $mainGame;

        return $this;
    }

    public function getExpansion(): ?BoardGame
    {
        return $this->expansion;
    }

    public function setExpansion(BoardGame $expansion): self
    {
        $this->expansion = $expansion;

        return $this;
    }

    public function getIsDependant(): ?bool
    {
        return $this->isDependant;
    }

    public function setIsDependant(bool $isDependant): self
    {
        $this->isDependant = $isDependant;

        return $this;
    }
}
