<?php

namespace App\Entity;

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
     * @ORM\OneToOne(targetEntity="App\Entity\ClassRoom", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $classRoom;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    public function getId()
    {
        return $this->id;
    }

    public function getClassRoom(): ?ClassRoom
    {
        return $this->classRoom;
    }

    public function setClassRoom(ClassRoom $classRoom): self
    {
        $this->classRoom = $classRoom;

        return $this;
    }

    public function getStudent(): ?User
    {
        return $this->student;
    }

    public function setStudent(User $student): self
    {
        $this->student = $student;

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
