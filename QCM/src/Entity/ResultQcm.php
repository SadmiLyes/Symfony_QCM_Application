<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultQcmRepository")
 */
class ResultQcm
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="resultQcm", cascade={"persist", "remove"})
     */
    private $student;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mark;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Session", inversedBy="resultQcm", cascade={"persist", "remove"})
     */
    private $session;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResultQuestion", mappedBy="resultQuestion")
     */
    private $resultQuestions;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Quiz", inversedBy="resultQcm", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $quiz;

    public function __construct()
    {
        $this->resultQuestions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStudent(): ?User
    {
        return $this->student;
    }

    public function setStudent(?User $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getMark(): ?int
    {
        return $this->mark;
    }

    public function setMark(?int $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return Collection|ResultQuestion[]
     */
    public function getResultQuestions(): Collection
    {
        return $this->resultQuestions;
    }

    public function addResultQuestion(ResultQuestion $resultQuestion): self
    {
        if (!$this->resultQuestions->contains($resultQuestion)) {
            $this->resultQuestions[] = $resultQuestion;
            $resultQuestion->setResultQuestion($this);
        }

        return $this;
    }

    public function removeResultQuestion(ResultQuestion $resultQuestion): self
    {
        if ($this->resultQuestions->contains($resultQuestion)) {
            $this->resultQuestions->removeElement($resultQuestion);
            // set the owning side to null (unless already changed)
            if ($resultQuestion->getResultQuestion() === $this) {
                $resultQuestion->setResultQuestion(null);
            }
        }

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }
}
