<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\ClassRoom", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $classRoom;

    /**
     * @ORM\Column(name="student_email", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $student;

    /**
     * @ORM\Column(type="boolean",nullable=true,options={"default" : false})
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

    public function getStudent(): ?string
    {
        return $this->student;
    }

    public function setStudent(string $student): self
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
