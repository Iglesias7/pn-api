<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups("Default")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=true)
     *
     * @Groups("Default")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=true)
     *
     * @Groups("Default")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("Default")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("Default")
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups("Default")
     */
    private $birthdate                         ;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("Default")
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("Default")
     */
    private $langue = 'fr';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("Default")
     */
    private $role = 'client';

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups("Default")
     */
    private $phoneNumber;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups("Default")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups("Default")
     */
    private $isLogin = false;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups("Default")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups("Default")
     */
    private $isActive = true;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups("Default")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("Default")
     */
    private $qualification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("Default")
     *
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("Default")
     */
    private $street;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups("Default")
     */
    private $adressDescription;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups("Default")
     */
    private $postalCode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups("Default")
     */
    private $landLinePhoneNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups("Default")
     */
    private $lastLoginDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups("Default")
     */
    private $createdDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups("Default")
     */
    private $updateDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups("Default")
     */
    private $deletedDate;

    /**
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="user", orphanRemoval=true)
     *
     * @Groups("Default")
     */
    private $votes;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="user", orphanRemoval=true)
     *
     * @Groups("Default")
     */
    private $services;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user", orphanRemoval=true)
     */
    private $comments;


    public function __construct()
    {
        $this->votes = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
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

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTime $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return (string)$this->password;
    }

    public function setPassword(?string $password): ?self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @return string[]
     * @see UserInterface
     *
     */
    public function getRoles(): array
    {
        $roles = ['ROLE_USER'];

//        if ($this->isAdmin) {
//            $roles[] = 'ROLE_ADMIN';
//        }

        return $roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIsLogin(): ?bool
    {
        return $this->isLogin;
    }

    public function setIsLogin(bool $isLogin): self
    {
        $this->isLogin = $isLogin;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

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

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(?string $qualification): self
    {
        $this->qualification = $qualification;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getAdressDescription(): ?string
    {
        return $this->adressDescription;
    }

    public function setAdressDescription(?string $adressDescription): self
    {
        $this->adressDescription = $adressDescription;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getLandLinePhoneNumber(): ?int
    {
        return $this->landLinePhoneNumber;
    }

    public function setLandLinePhoneNumber(?int $landLinePhoneNumber): self
    {
        $this->landLinePhoneNumber = $landLinePhoneNumber;

        return $this;
    }

    public function getLastLoginDate(): ?\DateTimeInterface
    {
        return $this->lastLoginDate;
    }

    public function setLastLoginDate(\DateTimeInterface $lastLoginDate): self
    {
        $this->lastLoginDate = $lastLoginDate;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    public function getDeletedDate(): ?\DateTimeInterface
    {
        return $this->deletedDate;
    }

    public function setDeletedDate(\DateTimeInterface $deletedDate): self
    {
        $this->deletedDate = $deletedDate;

        return $this;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setUser($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getUser() === $this) {
                $vote->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setUser($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getUser() === $this) {
                $service->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }
}
