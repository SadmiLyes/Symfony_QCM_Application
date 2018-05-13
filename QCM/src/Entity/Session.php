<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
 */
class Session
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ClassRoom", inversedBy="sessions")
     */
    private $classRoom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quiz", inversedBy="sessions")
     */
    private $quiz;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ResultQcm", mappedBy="session", cascade={"persist", "remove"})
     */
    private $resultQcm;

    public function __construct()
    {
        $this->classRoom = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|ClassRoom[]
     */

    public function setClassRoom(?ClassRoom $classRoom): self
    {
        if (!$this->classRoom->contains($classRoom)) {
            $this->classRoom[] = $classRoom;
        }

        return $this;
    }

    public function getClassRoom(): Collection
    {
        return $this->classRoom;
    }

    public function addClassRoom(ClassRoom $classRoom): self
    {
        if (!$this->classRoom->contains($classRoom)) {
            $this->classRoom[] = $classRoom;
        }

        return $this;
    }

    public function removeClassRoom(ClassRoom $classRoom): self
    {
        if ($this->classRoom->contains($classRoom)) {
            $this->classRoom->removeElement($classRoom);
        }

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

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
        $newSession = $resultQcm === null ? null : $this;
        if ($newSession !== $resultQcm->getSession()) {
            $resultQcm->setSession($newSession);
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return '';
    }
}
