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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date")
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Role", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $roleId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Group", mappedBy="author")
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Session", mappedBy="author")
     */
    private $sessions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResultQcm", mappedBy="studentId")
     */
    private $resultQcms;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->sessions = new ArrayCollection();
        $this->resultQcms = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
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

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getRoleId(): ?Role
    {
        return $this->roleId;
    }

    public function setRoleId(Role $roleId): self
    {
        $this->roleId = $roleId;

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

    /**
     * @return Collection|ResultQcm[]
     */
    public function getResultQcms(): Collection
    {
        return $this->resultQcms;
    }

    public function addResultQcm(ResultQcm $resultQcm): self
    {
        if (!$this->resultQcms->contains($resultQcm)) {
            $this->resultQcms[] = $resultQcm;
            $resultQcm->setStudentId($this);
        }

        return $this;
    }

    public function removeResultQcm(ResultQcm $resultQcm): self
    {
        if ($this->resultQcms->contains($resultQcm)) {
            $this->resultQcms->removeElement($resultQcm);
            // set the owning side to null (unless already changed)
            if ($resultQcm->getStudentId() === $this) {
                $resultQcm->setStudentId(null);
            }
        }

        return $this;
    }
}
