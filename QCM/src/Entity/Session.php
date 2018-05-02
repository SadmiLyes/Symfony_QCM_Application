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
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", inversedBy="sessions")
     */
    private $group_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_session;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Quiz", inversedBy="session", cascade={"persist", "remove"})
     */
    private $quiz_id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ResultQCM", mappedBy="session_id", cascade={"persist", "remove"})
     */
    private $resultQCM;

    public function __construct()
    {
        $this->group_id = new ArrayCollection();
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

    /**
     * @return Collection|Group[]
     */
    public function getGroupId(): Collection
    {
        return $this->group_id;
    }

    public function addGroupId(Group $groupId): self
    {
        if (!$this->group_id->contains($groupId)) {
            $this->group_id[] = $groupId;
        }

        return $this;
    }

    public function removeGroupId(Group $groupId): self
    {
        if ($this->group_id->contains($groupId)) {
            $this->group_id->removeElement($groupId);
        }

        return $this;
    }

    public function getDateSession(): ?\DateTimeInterface
    {
        return $this->date_session;
    }

    public function setDateSession(\DateTimeInterface $date_session): self
    {
        $this->date_session = $date_session;

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

    public function getResultQCM(): ?ResultQCM
    {
        return $this->resultQCM;
    }

    public function setResultQCM(?ResultQCM $resultQCM): self
    {
        $this->resultQCM = $resultQCM;

        // set (or unset) the owning side of the relation if necessary
        $newSession_id = $resultQCM === null ? null : $this;
        if ($newSession_id !== $resultQCM->getSessionId()) {
            $resultQCM->setSessionId($newSession_id);
        }

        return $this;
    }
}
