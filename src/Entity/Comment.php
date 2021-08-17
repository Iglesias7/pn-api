<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups("Default")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups("Default")
     */
    private $description;

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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups("Default")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups("Default")
     */
    private $isActive = true;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups("Default")
     */
    private $service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

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
}
