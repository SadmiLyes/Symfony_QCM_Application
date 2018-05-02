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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_points;

    /**
     * @ORM\Column(type="integer")
     */
    private $right_amount_point;

    /**
     * @ORM\Column(type="integer")
     */
    private $wrong_amount_point;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="quiz_id", orphanRemoval=true)
     */
    private $questions;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Session", mappedBy="quiz_id", cascade={"persist", "remove"})
     */
    private $session;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMaxPoints(): ?int
    {
        return $this->max_points;
    }

    public function setMaxPoints(int $max_points): self
    {
        $this->max_points = $max_points;

        return $this;
    }

    public function getRightAmountPoint(): ?int
    {
        return $this->right_amount_point;
    }

    public function setRightAmountPoint(int $right_amount_point): self
    {
        $this->right_amount_point = $right_amount_point;

        return $this;
    }

    public function getWrongAmountPoint(): ?int
    {
        return $this->wrong_amount_point;
    }

    public function setWrongAmountPoint(int $wrong_amount_point): self
    {
        $this->wrong_amount_point = $wrong_amount_point;

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

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        // set (or unset) the owning side of the relation if necessary
        $newQuiz_id = $session === null ? null : $this;
        if ($newQuiz_id !== $session->getQuizId()) {
            $session->setQuizId($newQuiz_id);
        }

        return $this;
    }
}
