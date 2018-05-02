<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="role_id", cascade={"persist", "remove"})
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Group", mappedBy="author", orphanRemoval=true)
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResultQCM", mappedBy="student_id", orphanRemoval=true)
     */
    private $resultQCMs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Session", mappedBy="author", orphanRemoval=true)
     */
    private $sessions;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->resultQCMs = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public function getId()
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getRole(): ?self
    {
        return $this->role;
    }

    public function setRole(self $role): self
    {
        $this->role = $role;

        // set the owning side of the relation if necessary
        if ($this !== $role->getRoleId()) {
            $role->setRoleId($this);
        }

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->setAuthor($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            // set the owning side to null (unless already changed)
            if ($group->getAuthor() === $this) {
                $group->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ResultQCM[]
     */
    public function getResultQCMs(): Collection
    {
        return $this->resultQCMs;
    }

    public function addResultQCM(ResultQCM $resultQCM): self
    {
        if (!$this->resultQCMs->contains($resultQCM)) {
            $this->resultQCMs[] = $resultQCM;
            $resultQCM->setStudentId($this);
        }

        return $this;
    }

    public function removeResultQCM(ResultQCM $resultQCM): self
    {
        if ($this->resultQCMs->contains($resultQCM)) {
            $this->resultQCMs->removeElement($resultQCM);
            // set the owning side to null (unless already changed)
            if ($resultQCM->getStudentId() === $this) {
                $resultQCM->setStudentId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setAuthor($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->contains($session)) {
            $this->sessions->removeElement($session);
            // set the owning side to null (unless already changed)
            if ($session->getAuthor() === $this) {
                $session->setAuthor(null);
            }
        }

        return $this;
    }
}
