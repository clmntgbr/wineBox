<?php

namespace App\Entity\Wine;

use App\Entity\Traits\DoctrineEventsTrait;
use App\Entity\Traits\WineTrait;
use App\Entity\User\User;
use App\Repository\Wine\CapacityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CapacityRepository::class)
 */
class Capacity extends AbstractWine
{
    use DoctrineEventsTrait;
    use WineTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @var Wine[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Wine\Wine",  mappedBy="capacity", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $wines;

    public function __construct()
    {
        $this->popularity = 0;
        $this->wines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }

    public function isCreator(User $user): bool
    {
        if ($this->createdBy->getId() == $user->getId()) {
            return true;
        }

        return false;
    }

    public function addPopularity(): void
    {
        $this->popularity++;
    }

    public function removePopularity(): void
    {
        $this->popularity--;
    }
}
