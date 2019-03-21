<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoryRepository")
 */
class History
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="guid")
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstQuery;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secondQuery;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="histories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ins_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $like_number;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cry_number;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $views;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getFirstQuery(): ?string
    {
        return $this->firstQuery;
    }

    public function setFirstQuery(string $firstQuery): self
    {
        $this->firstQuery = $firstQuery;

        return $this;
    }

    public function getSecondQuery(): ?string
    {
        return $this->secondQuery;
    }

    public function setSecondQuery(string $secondQuery): self
    {
        $this->secondQuery = $secondQuery;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getInsDate(): ?\DateTimeInterface
    {
        return $this->ins_date;
    }

    public function setInsDate(\DateTimeInterface $ins_date): self
    {
        $this->ins_date = $ins_date;

        return $this;
    }

    public function getLikeNumber(): ?int
    {
        return $this->like_number;
    }

    public function setLikeNumber(?int $like_number): self
    {
        $this->like_number = $like_number;

        return $this;
    }

    public function getCryNumber(): ?int
    {
        return $this->cry_number;
    }

    public function setCryNumber(?int $cry_number): self
    {
        $this->cry_number = $cry_number;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): self
    {
        $this->views = $views;

        return $this;
    }
}
