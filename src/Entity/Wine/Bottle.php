<?php

namespace App\Entity\Wine;

use App\Entity\Traits\DoctrineEventsTrait;
use App\Entity\Traits\WineTrait;
use App\Entity\User\User;
use App\Repository\Wine\BottleRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="wine_bottle")
 * @ORM\Entity(repositoryClass=BottleRepository::class)
 */
class Bottle extends AbstractWine
{
    use DoctrineEventsTrait;
    use WineTrait;

    const STATUS_FULL = 1;
    const STATUS_EMPTY = 2;
    const STATUS_DELETE = 3;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $familyCode;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $purchasePrice;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @var Box
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Wine\Box", inversedBy="bottles", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    public $box;

    /**
     * @var Bottle
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Wine\Wine", inversedBy="bottles", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    public $wine;

    /**
     * @var DateTimeImmutable|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $purchaseAt;

    /**
     * @var DateTimeImmutable|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $emptyAt;

    /**
     * @var DateTimeImmutable|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $apogeeAt;

    /**
     * @var DateTimeImmutable|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $alertAt;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $alertComment;

    public function __construct()
    {
        $this->popularity = 0;
        $this->status = self::STATUS_FULL;
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

    public function removePopularity(): void
    {
        $this->popularity--;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getFamilyCode(): ?string
    {
        return $this->familyCode;
    }

    public function setFamilyCode(string $familyCode): self
    {
        $this->familyCode = $familyCode;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(?float $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPurchaseAt(): ?\DateTimeInterface
    {
        return $this->purchaseAt;
    }

    public function setPurchaseAt(?\DateTimeInterface $purchaseAt): self
    {
        $this->purchaseAt = $purchaseAt;

        return $this;
    }

    public function getEmptyAt(): ?\DateTimeInterface
    {
        return $this->emptyAt;
    }

    public function setEmptyAt(?\DateTimeInterface $emptyAt): self
    {
        $this->emptyAt = $emptyAt;

        return $this;
    }

    public function getBox(): ?Box
    {
        return $this->box;
    }

    public function setBox(?Box $box): self
    {
        $this->box = $box;

        return $this;
    }

    public function getWine(): ?Wine
    {
        return $this->wine;
    }

    public function setWine(?Wine $wine): self
    {
        $this->wine = $wine;

        return $this;
    }

    public function getApogeeAt(): ?\DateTimeInterface
    {
        return $this->apogeeAt;
    }

    public function setApogeeAt(?\DateTimeInterface $apogeeAt): self
    {
        $this->apogeeAt = $apogeeAt;

        return $this;
    }

    public function getAlertAt(): ?\DateTimeInterface
    {
        return $this->alertAt;
    }

    public function setAlertAt(?\DateTimeInterface $alertAt): self
    {
        $this->alertAt = $alertAt;

        return $this;
    }

    public function getAlertComment(): ?string
    {
        return $this->alertComment;
    }

    public function setAlertComment(?string $alertComment): self
    {
        $this->alertComment = $alertComment;

        return $this;
    }
}
