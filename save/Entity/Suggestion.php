<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SuggestionRepository")
 */
class Suggestion
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
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRight;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="suggestions")
     */
    private $questionId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ResultQuestion", inversedBy="suggestionId")
     */
    private $resultQuestion;

    public function getId()
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsRight(): ?bool
    {
        return $this->isRight;
    }

    public function setIsRight(bool $isRight): self
    {
        $this->isRight = $isRight;

        return $this;
    }

    public function getQuestionId(): ?Question
    {
        return $this->questionId;
    }

    public function setQuestionId(?Question $questionId): self
    {
        $this->questionId = $questionId;

        return $this;
    }

    public function getResultQuestion(): ?ResultQuestion
    {
        return $this->resultQuestion;
    }

    public function setResultQuestion(?ResultQuestion $resultQuestion): self
    {
        $this->resultQuestion = $resultQuestion;

        return $this;
    }
}
