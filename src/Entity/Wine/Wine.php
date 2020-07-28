<?php

namespace App\Entity\Wine;

use App\Entity\Traits\DoctrineEventsTrait;
use App\Entity\Traits\WineTrait;
use App\Entity\User\User;
use App\Repository\Wine\WineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="wine")
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

    /**
     * @var Appellation
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Wine\Appellation", inversedBy="wines", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    public $appellation;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Wine\Region", inversedBy="wines", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    public $region;

    /**
     * @var Domain
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Wine\Domain", inversedBy="wines", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    public $domain;

    /**
     * @var Bottle[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Wine\Bottle",  mappedBy="wine", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $bottles;

    public function __construct()
    {
        $this->popularity = 0;
        $this->bottles = new ArrayCollection();
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

    public function getCapacity(): ?Capacity
    {
        return $this->capacity;
    }

    public function setCapacity(?Capacity $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getAppellation(): ?Appellation
    {
        return $this->appellation;
    }

    public function setAppellation(?Appellation $appellation): self
    {
        $this->appellation = $appellation;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(?Domain $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return Collection|Bottle[]
     */
    public function getBottles(): Collection
    {
        return $this->bottles;
    }

    public function addBottle(Bottle $bottle): self
    {
        if (!$this->bottles->contains($bottle)) {
            $this->bottles[] = $bottle;
            $bottle->setWines($this);
        }

        return $this;
    }

    public function removeBottle(Bottle $bottle): self
    {
        if ($this->bottles->contains($bottle)) {
            $this->bottles->removeElement($bottle);
            // set the owning side to null (unless already changed)
            if ($bottle->getWines() === $this) {
                $bottle->setWines(null);
            }
        }

        return $this;
    }
}
