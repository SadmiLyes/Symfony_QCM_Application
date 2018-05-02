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
     * @ORM\Column(type="float")
     */
    private $mark;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="resultQcms")
     */
    private $studentId;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Quiz", cascade={"persist", "remove"})
     */
    private $quizId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Session", inversedBy="resultQcms")
     */
    private $sessionId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResultQuestion", mappedBy="resultQcmId")
     */
    private $resultQuestions;

    public function __construct()
    {
        $this->resultQuestions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMark(): ?float
    {
        return $this->mark;
    }

    public function setMark(float $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getStudentId(): ?User
    {
        return $this->studentId;
    }

    public function setStudentId(?User $studentId): self
    {
        $this->studentId = $studentId;

        return $this;
    }

    public function getQuizId(): ?Quiz
    {
        return $this->quizId;
    }

    public function setQuizId(?Quiz $quizId): self
    {
        $this->quizId = $quizId;

        return $this;
    }

    public function getSessionId(): ?Session
    {
        return $this->sessionId;
    }

    public function setSessionId(?Session $sessionId): self
    {
        $this->sessionId = $sessionId;

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
            $resultQuestion->setResultQcmId($this);
        }

        return $this;
    }

    public function removeResultQuestion(ResultQuestion $resultQuestion): self
    {
        if ($this->resultQuestions->contains($resultQuestion)) {
            $this->resultQuestions->removeElement($resultQuestion);
            // set the owning side to null (unless already changed)
            if ($resultQuestion->getResultQcmId() === $this) {
                $resultQuestion->setResultQcmId(null);
            }
        }

        return $this;
    }
}
