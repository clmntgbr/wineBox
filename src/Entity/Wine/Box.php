<?php

namespace App\Entity\Wine;

use App\Entity\Traits\DoctrineEventsTrait;
use App\Entity\Traits\WineTrait;
use App\Entity\User\User;
use App\Repository\Wine\BoxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="wine_box")
 * @ORM\Entity(repositoryClass=BoxRepository::class)
 */
class Box extends AbstractWine
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
     * @var Bottle[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Wine\Bottle",  mappedBy="box", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $bottles;

    public function __construct(User $user)
    {
        $this->createdBy = $user;
        $this->name = 'My Box';
        $this->description = 'My Box Description';
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

    public function hasUploadedFile(): bool
    {
        if ($this->file instanceof UploadedFile) {
            return true;
        }
        return false;
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

    public function addQuantity(): self
    {
        $this->quantity++;

        return $this;
    }

    public function addLiter(float $liter): self
    {
        $this->liter = $this->liter + $liter;

        return $this;
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
            $bottle->setBox($this);
        }

        return $this;
    }

    public function removeBottle(Bottle $bottle): self
    {
        if ($this->bottles->contains($bottle)) {
            $this->bottles->removeElement($bottle);
            // set the owning side to null (unless already changed)
            if ($bottle->getBox() === $this) {
                $bottle->setBox(null);
            }
        }

        return $this;
    }
}
