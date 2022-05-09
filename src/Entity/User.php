<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateBirth;

    /**
     * @ORM\OneToMany(targetEntity=BoardGameWish::class, mappedBy="user", orphanRemoval=true)
     */
    private $boardGameWishes;

    /**
     * @ORM\OneToMany(targetEntity=BoardGameOwned::class, mappedBy="user", orphanRemoval=true)
     */
    private $boardGameOwneds;

    /**
     * @ORM\OneToMany(targetEntity=BoardGameNote::class, mappedBy="user", orphanRemoval=true)
     */
    private $boardGameNotes;

    public function __construct()
    {
        $this->boardGameWishes = new ArrayCollection();
        $this->boardGameOwneds = new ArrayCollection();
        $this->boardGameNotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateBirth(): ?\DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(\DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    /**
     * @return Collection<int, BoardGameWish>
     */
    public function getBoardGameWishes(): Collection
    {
        return $this->boardGameWishes;
    }

    public function addBoardGameWish(BoardGameWish $boardGameWish): self
    {
        if (!$this->boardGameWishes->contains($boardGameWish)) {
            $this->boardGameWishes[] = $boardGameWish;
            $boardGameWish->setUser($this);
        }

        return $this;
    }

    public function removeBoardGameWish(BoardGameWish $boardGameWish): self
    {
        if ($this->boardGameWishes->removeElement($boardGameWish)) {
            // set the owning side to null (unless already changed)
            if ($boardGameWish->getUser() === $this) {
                $boardGameWish->setUser(null);
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

    public function addBoardGameOwned(BoardGameOwned $boardGameOwned): self
    {
        if (!$this->boardGameOwneds->contains($boardGameOwned)) {
            $this->boardGameOwneds[] = $boardGameOwned;
            $boardGameOwned->setUser($this);
        }

        return $this;
    }

    public function removeBoardGameOwned(BoardGameOwned $boardGameOwned): self
    {
        if ($this->boardGameOwneds->removeElement($boardGameOwned)) {
            // set the owning side to null (unless already changed)
            if ($boardGameOwned->getUser() === $this) {
                $boardGameOwned->setUser(null);
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
            $boardGameNote->setUser($this);
        }

        return $this;
    }

    public function removeBoardGameNote(BoardGameNote $boardGameNote): self
    {
        if ($this->boardGameNotes->removeElement($boardGameNote)) {
            // set the owning side to null (unless already changed)
            if ($boardGameNote->getUser() === $this) {
                $boardGameNote->setUser(null);
            }
        }

        return $this;
    }
}
