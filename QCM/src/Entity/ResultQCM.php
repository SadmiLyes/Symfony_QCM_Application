<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultQCMRepository")
 */
class ResultQCM
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="resultQCMs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student_id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Quiz", cascade={"persist", "remove"})
     */
    private $quiz_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mark;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Session", inversedBy="resultQCM", cascade={"persist", "remove"})
     */
    private $session_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResultQuestion", mappedBy="result_qcm_id")
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

    public function getStudentId(): ?User
    {
        return $this->student_id;
    }

    public function setStudentId(?User $student_id): self
    {
        $this->student_id = $student_id;

        return $this;
    }

    public function getQuizId(): ?Quiz
    {
        return $this->quiz_id;
    }

    public function setQuizId(?Quiz $quiz_id): self
    {
        $this->quiz_id = $quiz_id;

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

    public function getSessionId(): ?Session
    {
        return $this->session_id;
    }

    public function setSessionId(?Session $session_id): self
    {
        $this->session_id = $session_id;

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
