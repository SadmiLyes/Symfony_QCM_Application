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
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Role", inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClassRoom", mappedBy="author", orphanRemoval=true)
     */
    private $classRooms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Session", mappedBy="author", orphanRemoval=true)
     */
    private $sessions;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ResultQcm", mappedBy="student", cascade={"persist", "remove"})
     */
    private $resultQcm;

    public function __construct()
    {
        $this->classRooms = new ArrayCollection();
        $this->sessions = new ArrayCollection();
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

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|ClassRoom[]
     */
    public function getClassRooms(): Collection
    {
        return $this->classRooms;
    }

    public function addClassRoom(ClassRoom $classRoom): self
    {
        if (!$this->classRooms->contains($classRoom)) {
            $this->classRooms[] = $classRoom;
            $classRoom->setAuthor($this);
        }

        return $this;
    }

    public function removeClassRoom(ClassRoom $classRoom): self
    {
        if ($this->classRooms->contains($classRoom)) {
            $this->classRooms->removeElement($classRoom);
            // set the owning side to null (unless already changed)
            if ($classRoom->getAuthor() === $this) {
                $classRoom->setAuthor(null);
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

    public function getResultQcm(): ?ResultQcm
    {
        return $this->resultQcm;
    }

    public function setResultQcm(?ResultQcm $resultQcm): self
    {
        $this->resultQcm = $resultQcm;

        // set (or unset) the owning side of the relation if necessary
        $newStudent = $resultQcm === null ? null : $this;
        if ($newStudent !== $resultQcm->getStudent()) {
            $resultQcm->setStudent($newStudent);
        }

        return $this;
    }
}
