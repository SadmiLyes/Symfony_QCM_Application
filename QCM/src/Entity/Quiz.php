<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuizRepository")
 */
class Quiz
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxPoints;

    /**
     * @ORM\Column(type="integer")
     */
    private $rightAmountPoints;

    /**
     * @ORM\Column(type="integer")
     */
    private $wrongAmountPoints;

    /**
     * @ORM\Column(type="integer")
     */
    private $neutralAmountPoints;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="quizId")
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Session", mappedBy="quizId")
     */
    private $sessions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getMaxPoints(): ?int
    {
        return $this->maxPoints;
    }

    public function setMaxPoints(int $maxPoints): self
    {
        $this->maxPoints = $maxPoints;

        return $this;
    }

    public function getRightAmountPoints(): ?int
    {
        return $this->rightAmountPoints;
    }

    public function setRightAmountPoints(int $rightAmountPoints): self
    {
        $this->rightAmountPoints = $rightAmountPoints;

        return $this;
    }

    public function getWrongAmountPoints(): ?int
    {
        return $this->wrongAmountPoints;
    }

    public function setWrongAmountPoints(int $wrongAmountPoints): self
    {
        $this->wrongAmountPoints = $wrongAmountPoints;

        return $this;
    }

    public function getNeutralAmountPoints(): ?int
    {
        return $this->neutralAmountPoints;
    }

    public function setNeutralAmountPoints(int $neutralAmountPoints): self
    {
        $this->neutralAmountPoints = $neutralAmountPoints;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setQuizId($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getQuizId() === $this) {
                $question->setQuizId(null);
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
            $session->setQuizId($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->contains($session)) {
            $this->sessions->removeElement($session);
            // set the owning side to null (unless already changed)
            if ($session->getQuizId() === $this) {
                $session->setQuizId(null);
            }
        }

        return $this;
    }
}
