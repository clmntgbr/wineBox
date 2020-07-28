<?php

namespace App\Entity\Wine;

use App\Entity\Traits\DoctrineEventsTrait;
use App\Entity\Traits\WineTrait;
use App\Entity\User\User;
use App\Repository\Wine\CellarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="wine_cellar")
 * @ORM\Entity(repositoryClass=CellarRepository::class)
 */
class Cellar extends AbstractWine
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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $horizontal = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $vertical = 10;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $quantity = 0;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $liter = 0;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User\User", inversedBy="cellar", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var Bottle[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Wine\Bottle",  mappedBy="cellar", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $bottles;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->createdBy = $user;
        $this->name = 'My Cellar';
        $this->slug = 'my-cellar';
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

    public function getHorizontal(): ?int
    {
        return $this->horizontal;
    }

    public function setHorizontal(int $horizontal): self
    {
        $this->horizontal = $horizontal;

        return $this;
    }

    public function getVertical(): ?int
    {
        return $this->vertical;
    }

    public function setVertical(int $vertical): self
    {
        $this->vertical = $vertical;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getLiter(): ?float
    {
        return $this->liter;
    }

    public function setLiter(float $liter): self
    {
        $this->liter = $liter;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $bottle->setCellar($this);
        }

        return $this;
    }

    public function removeBottle(Bottle $bottle): self
    {
        if ($this->bottles->contains($bottle)) {
            $this->bottles->removeElement($bottle);
            // set the owning side to null (unless already changed)
            if ($bottle->getCellar() === $this) {
                $bottle->setCellar(null);
            }
        }

        return $this;
    }
}
