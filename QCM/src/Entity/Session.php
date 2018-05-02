<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
 */
class Session
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sessions")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quiz", inversedBy="sessions")
     */
    private $quizId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Group", mappedBy="session")
     */
    private $groupId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endTime;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResultQcm", mappedBy="sessionId")
     */
    private $resultQcms;

    public function __construct()
    {
        $this->groupId = new ArrayCollection();
        $this->resultQcms = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

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
     * @return Collection|Group[]
     */
    public function getGroupId(): Collection
    {
        return $this->groupId;
    }

    public function addGroupId(Group $groupId): self
    {
        if (!$this->groupId->contains($groupId)) {
            $this->groupId[] = $groupId;
            $groupId->setSession($this);
        }

        return $this;
    }

    public function removeGroupId(Group $groupId): self
    {
        if ($this->groupId->contains($groupId)) {
            $this->groupId->removeElement($groupId);
            // set the owning side to null (unless already changed)
            if ($groupId->getSession() === $this) {
                $groupId->setSession(null);
            }
        }

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @return Collection|ResultQcm[]
     */
    public function getResultQcms(): Collection
    {
        return $this->resultQcms;
    }

    public function addResultQcm(ResultQcm $resultQcm): self
    {
        if (!$this->resultQcms->contains($resultQcm)) {
            $this->resultQcms[] = $resultQcm;
            $resultQcm->setSessionId($this);
        }

        return $this;
    }

    public function removeResultQcm(ResultQcm $resultQcm): self
    {
        if ($this->resultQcms->contains($resultQcm)) {
            $this->resultQcms->removeElement($resultQcm);
            // set the owning side to null (unless already changed)
            if ($resultQcm->getSessionId() === $this) {
                $resultQcm->setSessionId(null);
            }
        }

        return $this;
    }
}
