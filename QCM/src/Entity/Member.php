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
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", inversedBy="members")
     */
    private $groupId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    public function __construct()
    {
        $this->groupId = new ArrayCollection();
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
     * @return Collection|Group[]
     */
    public function getGroupId(): Collection
    {
        return $this->groupId;
    }

    public function addGroupId(Group $groupId): self
    {
        if (!$this->groupId->contains($groupId)) {
            $this->groupId[] = $groupId;
        }

        return $this;
    }

    public function removeGroupId(Group $groupId): self
    {
        if ($this->groupId->contains($groupId)) {
            $this->groupId->removeElement($groupId);
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
