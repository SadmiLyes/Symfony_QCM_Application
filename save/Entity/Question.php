<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
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
    private $enunciate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isMultiple;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quiz", inversedBy="questions")
     */
    private $quizId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Suggestion", mappedBy="questionId")
     */
    private $suggestions;

    public function __construct()
    {
        $this->suggestions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEnunciate(): ?string
    {
        return $this->enunciate;
    }

    public function setEnunciate(string $enunciate): self
    {
        $this->enunciate = $enunciate;

        return $this;
    }

    public function getIsMultiple(): ?bool
    {
        return $this->isMultiple;
    }

    public function setIsMultiple(bool $isMultiple): self
    {
        $this->isMultiple = $isMultiple;

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

    /**
     * @return Collection|Suggestion[]
     */
    public function getSuggestions(): Collection
    {
        return $this->suggestions;
    }

    public function addSuggestion(Suggestion $suggestion): self
    {
        if (!$this->suggestions->contains($suggestion)) {
            $this->suggestions[] = $suggestion;
            $suggestion->setQuestionId($this);
        }

        return $this;
    }

    public function removeSuggestion(Suggestion $suggestion): self
    {
        if ($this->suggestions->contains($suggestion)) {
            $this->suggestions->removeElement($suggestion);
            // set the owning side to null (unless already changed)
            if ($suggestion->getQuestionId() === $this) {
                $suggestion->setQuestionId(null);
            }
        }

        return $this;
    }
}
