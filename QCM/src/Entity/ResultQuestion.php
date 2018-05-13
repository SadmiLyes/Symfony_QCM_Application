<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultQuestionRepository")
 */
class ResultQuestion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Suggestion", cascade={"persist", "remove"})
     */
    private $suggestion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ResultQcm", inversedBy="resultQuestions")
     */
    private $resultQuestion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $given;

    public function getId()
    {
        return $this->id;
    }

    public function getSuggestion(): ?Suggestion
    {
        return $this->suggestion;
    }

    public function setSuggestion(?Suggestion $suggestion): self
    {
        $this->suggestion = $suggestion;

        return $this;
    }

    public function getResultQuestion(): ?ResultQcm
    {
        return $this->resultQuestion;
    }

    public function setResultQuestion(?ResultQcm $resultQuestion): self
    {
        $this->resultQuestion = $resultQuestion;

        return $this;
    }

    public function getGiven(): ?bool
    {
        return $this->given;
    }

    public function setGiven(bool $given): self
    {
        $this->given = $given;

        return $this;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return '';
    }
}
