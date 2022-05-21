<?php

namespace App\Entity;

use App\Repository\BoardGameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BoardGameRepository::class)
 */
class BoardGame
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"ajax"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *     max = 255
     * )
     * @Groups({"ajax"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min = 0)
     * @Groups({"ajax"})
     */
    private $nbMinPlayer;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min = 1)
     * @Groups({"ajax"})
     */
    private $nbMaxPlayer;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min = 5)
     * @Groups({"ajax"})
     */
    private $gameTime;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min = 0)
     * @Groups({"ajax"})
     */
    private $ageMin;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"ajax"})
     */
    private $target;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Range(min = 0)
     * @Groups({"ajax"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Range::class, inversedBy="boardGames")
     */
    private $gamme;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAdd;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdate;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="boardGame", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"position" = "ASC"})
     * @Groups({"ajax"})
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=BoardGameMarket::class, mappedBy="boardGame", orphanRemoval=true)
     */
    private $boardGameMarkets;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="boardGame", orphanRemoval=true)
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity=Expansion::class, mappedBy="mainGame", orphanRemoval=true)
     */
    private $expansions;

    /**
     * @ORM\OneToOne(targetEntity=Expansion::class, mappedBy="expansion", cascade={"persist", "remove"})
     */
    private $expansion;

    /**
     * @ORM\OneToMany(targetEntity=BoardGameTheme::class, mappedBy="boardGame", orphanRemoval=true)
     */
    private $boardGameThemes;

    /**
     * @ORM\OneToMany(targetEntity=BoardGameType::class, mappedBy="boardGame", orphanRemoval=true)
     */
    private $boardGameTypes;

    /**
     * @ORM\OneToMany(targetEntity=BoardGameWish::class, mappedBy="boardGame", orphanRemoval=true)
     */
    private $boardGameWishes;

    /**
     * @ORM\OneToMany(targetEntity=BoardGameOwned::class, mappedBy="boardGame", orphanRemoval=true)
     */
    private $boardGameOwneds;

    /**
     * @ORM\OneToMany(targetEntity=BoardGameNote::class, mappedBy="boardGame", orphanRemoval=true)
     */
    private $boardGameNotes;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
        $this->dateUpdate = new \DateTime();
        $this->images = new ArrayCollection();
        $this->boardGameMarkets = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->expansions = new ArrayCollection();
        $this->boardGameThemes = new ArrayCollection();
        $this->boardGameTypes = new ArrayCollection();
        $this->boardGameNotes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNbMinPlayer(): ?int
    {
        return $this->nbMinPlayer;
    }

    public function setNbMinPlayer(int $nbMinPlayer): self
    {
        $this->nbMinPlayer = $nbMinPlayer;

        return $this;
    }

    public function getNbMaxPlayer(): ?int
    {
        return $this->nbMaxPlayer;
    }

    public function setNbMaxPlayer(int $nbMaxPlayer): self
    {
        $this->nbMaxPlayer = $nbMaxPlayer;

        return $this;
    }

    public function getGameTime(): ?int
    {
        return $this->gameTime;
    }

    public function setGameTime(int $gameTime): self
    {
        $this->gameTime = $gameTime;

        return $this;
    }

    public function getAgeMin(): ?int
    {
        return $this->ageMin;
    }

    public function setAgeMin(int $ageMin): self
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getGamme(): ?Range
    {
        return $this->gamme;
    }

    public function setGamme(?Range $gamme): self
    {
        $this->gamme = $gamme;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(\DateTimeInterface $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setBoardGame($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getBoardGame() === $this) {
                $image->setBoardGame(null);
            }
        }

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
            $boardGameMarket->setBoardGame($this);
        }

        return $this;
    }

    public function removeBoardGameMarket(BoardGameMarket $boardGameMarket): self
    {
        if ($this->boardGameMarkets->removeElement($boardGameMarket)) {
            // set the owning side to null (unless already changed)
            if ($boardGameMarket->getBoardGame() === $this) {
                $boardGameMarket->setBoardGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setBoardGame($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getBoardGame() === $this) {
                $video->setBoardGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Expansion>
     */
    public function getExpansions(): Collection
    {
        return $this->expansions;
    }

    public function addExpansion(Expansion $expansion): self
    {
        if (!$this->expansions->contains($expansion)) {
            $this->expansions[] = $expansion;
            $expansion->setMainGame($this);
        }

        return $this;
    }

    public function removeExpansion(Expansion $expansion): self
    {
        if ($this->expansions->removeElement($expansion)) {
            // set the owning side to null (unless already changed)
            if ($expansion->getMainGame() === $this) {
                $expansion->setMainGame(null);
            }
        }

        return $this;
    }

    public function getExpansion(): ?Expansion
    {
        return $this->expansion;
    }

    public function setExpansion(Expansion $expansion): self
    {
        // set the owning side of the relation if necessary
        if ($expansion->getExpansion() !== $this) {
            $expansion->setExpansion($this);
        }

        $this->expansion = $expansion;

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
            $boardGameTheme->setBoardGame($this);
        }

        return $this;
    }

    public function removeBoardGameTheme(BoardGameTheme $boardGameTheme): self
    {
        if ($this->boardGameThemes->removeElement($boardGameTheme)) {
            // set the owning side to null (unless already changed)
            if ($boardGameTheme->getBoardGame() === $this) {
                $boardGameTheme->setBoardGame(null);
            }
        }

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
            $boardGameType->setBoardGame($this);
        }

        return $this;
    }

    public function removeBoardGameType(BoardGameType $boardGameType): self
    {
        if ($this->boardGameTypes->removeElement($boardGameType)) {
            // set the owning side to null (unless already changed)
            if ($boardGameType->getBoardGame() === $this) {
                $boardGameType->setBoardGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoardGameWish>
     */
    public function getBoardGameWishes(): Collection
    {
        return $this->boardGameWishes;
    }

    public function addBoardGameWishes(BoardGameWish $boardGameWish): self
    {
        if (!$this->boardGameWishes->contains($boardGameWish)) {
            $this->boardGameWishes[] = $boardGameWish;
            $boardGameWish->setBoardGame($this);
        }

        return $this;
    }

    public function removeBoardGameWishes(BoardGameWish $boardGameWish): self
    {
        if ($this->boardGameWishes->removeElement($boardGameWish)) {
            // set the owning side to null (unless already changed)
            if ($boardGameWish->getBoardGame() === $this) {
                $boardGameWish->setBoardGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoardGameOwned>
     */
    public function getBoardGameOwneds(): Collection
    {
        return $this->boardGameOwneds;
    }

    public function addBoardGameOwneds(BoardGameOwned $boardGameOwned): self
    {
        if (!$this->boardGameOwneds->contains($boardGameOwned)) {
            $this->boardGameOwneds[] = $boardGameOwned;
            $boardGameOwned->setBoardGame($this);
        }

        return $this;
    }

    public function removeBoardGameOwneds(BoardGameOwned $boardGameOwned): self
    {
        if ($this->boardGameOwneds->removeElement($boardGameOwned)) {
            // set the owning side to null (unless already changed)
            if ($boardGameOwned->getBoardGame() === $this) {
                $boardGameOwned->setBoardGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoardGameNote>
     */
    public function getBoardGameNotes(): Collection
    {
        return $this->boardGameNotes;
    }

    public function addBoardGameNote(BoardGameNote $boardGameNote): self
    {
        if (!$this->boardGameNotes->contains($boardGameNote)) {
            $this->boardGameNotes[] = $boardGameNote;
            $boardGameNote->setBoardGame($this);
        }

        return $this;
    }

    public function removeBoardGameNote(BoardGameNote $boardGameNote): self
    {
        if ($this->boardGameNotes->removeElement($boardGameNote)) {
            // set the owning side to null (unless already changed)
            if ($boardGameNote->getBoardGame() === $this) {
                $boardGameNote->setBoardGame(null);
            }
        }

        return $this;
    }

    public function isWishByUser(User $user): bool
    {
        foreach ($this->boardGameWishes as $wish) {
            if ($wish->getUser() === $user) return true;
        }

        return false;
    }

    public function isOwnByUser(User $user): bool
    {
        foreach ($this->boardGameOwneds as $own) {
            if ($own->getUser() === $user) return true;
        }

        return false;
    }
}
