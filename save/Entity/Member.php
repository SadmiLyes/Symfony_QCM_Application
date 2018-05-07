<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;

    /**
     * @ORM\ManyToMany(targetEntity="ClassRoom", inversedBy="members")
     */
    private $ClassRoomId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    public function __construct()
    {
        $this->ClassRoomId = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Collection|ClassRoom[]
     */
    public function getClassRoomId(): Collection
    {
        return $this->ClassRoomId;
    }

    public function addClassRoomId(ClassRoom $ClassRoomId): self
    {
        if (!$this->ClassRoomId->contains($ClassRoomId)) {
            $this->ClassRoomId[] = $ClassRoomId;
        }

        return $this;
    }

    public function removeClassRoomId(ClassRoom $ClassRoomId): self
    {
        if ($this->ClassRoomId->contains($ClassRoomId)) {
            $this->ClassRoomId->removeElement($ClassRoomId);
        }

        return $this;
    }

    public function getIsConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(bool $isConfirmed): self
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }
}
