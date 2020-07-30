<?php

namespace App\Entity\Traits;

use App\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

trait WineTrait
{
    /**
     * @var UploadedFile|null
     */
    public $file;

    /**
     * @var string
     *
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string")
     */
    public $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     *
     * @ORM\Column(length=128, unique=true)
     */
    public $slug;

    /**
     * @var string
     *
     * @Assert\NotBlank
     *
     * @ORM\Column(type="text")
     */
    public $description;

    /**
     * @var float
     *
     * @ORM\Column(type="float", options={"default" : 0})
     */
    private $popularity = 0;

    /**
     * @var Media
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Media", cascade={"persist", "remove"}, fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="preview_id", referencedColumnName="id")
     */
    private $preview;

    /**
     * @return UploadedFile|null
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile|null $file
     */
    public function setFile(?UploadedFile $file): void
    {
        $this->file = $file;
    }

    /**
     * @return float
     */
    public function getPopularity(): float
    {
        return $this->popularity;
    }

    /**
     * @param float $popularity
     */
    public function setPopularity(float $popularity): void
    {
        $this->popularity = $popularity;
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Media
     */
    public function getPreview(): Media
    {
        return $this->preview;
    }

    /**
     * @param Media $preview
     */
    public function setPreview(Media $preview): void
    {
        $this->preview = $preview;
    }
}