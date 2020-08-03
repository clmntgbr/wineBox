<?php

namespace App\Entity;

use App\Entity\Wine\Region;
use App\Entity\Wine\Wine;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     *
     * @ORM\Column(unique=true)
     */
    public $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $flag;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $iso2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $iso3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $isoNumeric;

    /**
     * @var float
     *
     * @ORM\Column(type="float", options={"default" : 0})
     */
    private $popularity = 0;

    /**
     * @var Wine[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Wine\Region",  mappedBy="country", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $regions;

    public function __construct()
    {
        $this->popularity = 0;
        $this->regions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(string $flag): self
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * @return Collection|Region[]
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions[] = $region;
            $region->setCountry($this);
        }

        return $this;
    }

    public function removeRegion(Region $region): self
    {
        if ($this->regions->contains($region)) {
            $this->regions->removeElement($region);
            // set the owning side to null (unless already changed)
            if ($region->getCountry() === $this) {
                $region->setCountry(null);
            }
        }

        return $this;
    }

    public function getIso2(): ?string
    {
        return $this->iso2;
    }

    public function setIso2(string $iso2): self
    {
        $this->iso2 = $iso2;

        return $this;
    }

    public function getIso3(): ?string
    {
        return $this->iso3;
    }

    public function setIso3(string $iso3): self
    {
        $this->iso3 = $iso3;

        return $this;
    }

    public function getIsoNumeric(): ?string
    {
        return $this->isoNumeric;
    }

    public function setIsoNumeric(string $isoNumeric): self
    {
        $this->isoNumeric = $isoNumeric;

        return $this;
    }

    public function getPopularity(): ?float
    {
        return $this->popularity;
    }

    public function setPopularity(float $popularity): self
    {
        $this->popularity = $popularity;

        return $this;
    }
}
