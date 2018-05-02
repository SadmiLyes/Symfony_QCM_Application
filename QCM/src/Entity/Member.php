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
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", inversedBy="members")
     */
    private $group_id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $confirmed;

    public function __construct()
    {
        $this->group_id = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroupId(): Collection
    {
        return $this->group_id;
    }

    public function addGroupId(Group $groupId): self
    {
        if (!$this->group_id->contains($groupId)) {
            $this->group_id[] = $groupId;
        }

        return $this;
    }

    public function removeGroupId(Group $groupId): self
    {
        if ($this->group_id->contains($groupId)) {
            $this->group_id->removeElement($groupId);
        }

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }
}
