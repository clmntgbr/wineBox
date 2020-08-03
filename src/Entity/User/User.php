<?php

namespace App\Entity\User;

use App\Entity\Traits\DoctrineEventsTrait;
use App\Entity\Wine\Box;
use App\Repository\User\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User extends BaseUser
{
    use DoctrineEventsTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var Box
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Wine\Box", cascade={"persist"}, fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="box_id", referencedColumnName="id")
     */
    private $box;

    public function __construct()
    {
        parent::__construct();
        $this->box = new Box($this);
    }

    public function setEmail($email): self
    {
        parent::setEmail($email);
        $this->setUsername($email);
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBox(): Box
    {
        return $this->box;
    }

    public function setBox(Box $box): self
    {
        $this->box = $box;

        return $this;
    }
}
