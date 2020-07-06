<?php

namespace App\Entity\Traits;

use App\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait WineTrait
{
    /** @var UploadedFile|null */
    public $file;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $slug;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    public $description;

    /**
     * @var float
     *
     * @ORM\Column(type="float", options={"default" : 0})
     */
    private $popularity;

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


}