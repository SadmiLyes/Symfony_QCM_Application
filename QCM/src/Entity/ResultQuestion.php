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
    private $suggestion_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ResultQCM", inversedBy="resultQuestions")
     */
    private $result_qcm_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $given;

    public function getId()
    {
        return $this->id;
    }

    public function getSuggestionId(): ?Suggestion
    {
        return $this->suggestion_id;
    }

    public function setSuggestionId(?Suggestion $suggestion_id): self
    {
        $this->suggestion_id = $suggestion_id;

        return $this;
    }

    public function getResultQcmId(): ?ResultQCM
    {
        return $this->result_qcm_id;
    }

    public function setResultQcmId(?ResultQCM $result_qcm_id): self
    {
        $this->result_qcm_id = $result_qcm_id;

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
