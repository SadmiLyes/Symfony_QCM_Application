<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity="App\Entity\Suggestion", mappedBy="resultQuestion")
     */
    private $suggestionId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ResultQcm", inversedBy="resultQuestions")
     */
    private $resultQcmId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $given;

    public function __construct()
    {
        $this->suggestionId = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|Suggestion[]
     */
    public function getSuggestionId(): Collection
    {
        return $this->suggestionId;
    }

    public function addSuggestionId(Suggestion $suggestionId): self
    {
        if (!$this->suggestionId->contains($suggestionId)) {
            $this->suggestionId[] = $suggestionId;
            $suggestionId->setResultQuestion($this);
        }

        return $this;
    }

    public function removeSuggestionId(Suggestion $suggestionId): self
    {
        if ($this->suggestionId->contains($suggestionId)) {
            $this->suggestionId->removeElement($suggestionId);
            // set the owning side to null (unless already changed)
            if ($suggestionId->getResultQuestion() === $this) {
                $suggestionId->setResultQuestion(null);
            }
        }

        return $this;
    }

    public function getResultQcmId(): ?ResultQcm
    {
        return $this->resultQcmId;
    }

    public function setResultQcmId(?ResultQcm $resultQcmId): self
    {
        $this->resultQcmId = $resultQcmId;

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
}
