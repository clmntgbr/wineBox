<?php

namespace App\Entity\Traits;

use App\Entity\User\User;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait DoctrineEventsTrait
{
    /**
     * @var \DateTime|null
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var User|null
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true))
     */
    private $createdBy;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        if ($this->createdAt) {
            return DateTimeImmutable::createFromMutable($this->createdAt);
        }
        return null;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        if ($this->updatedAt) {
            return DateTimeImmutable::createFromMutable($this->updatedAt);
        }
        return null;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    /**
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param User|null $createdBy
     */
    public function setCreatedBy(?User $createdBy): void
    {
        $this->createdBy = $createdBy;
    }
}