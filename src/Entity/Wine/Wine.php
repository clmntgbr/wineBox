<?php

namespace App\Entity\Wine;

use App\Entity\Traits\DoctrineEventsTrait;
use App\Entity\Traits\WineTrait;
use App\Entity\User\User;
use App\Repository\Wine\WineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WineRepository::class)
 */
class Wine extends AbstractWine
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
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    public $description;

    /**
     * @var Capacity
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Wine\Capacity", inversedBy="wines", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    public $capacity;

    /**
     * @var Color
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Wine\Color", inversedBy="wines", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    public $color;

    public function __construct()
    {
        $this->popularity = 0;
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
