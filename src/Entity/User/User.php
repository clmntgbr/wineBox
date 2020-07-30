<?php

namespace App\Entity\User;

use App\Entity\Traits\DoctrineEventsTrait;
use App\Entity\Wine\Cellar;
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
     * @var Cellar
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Wine\Cellar", mappedBy="user", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="cellar_id", referencedColumnName="id")
     */
    private $cellar;

    public function __construct()
    {
        parent::__construct();
        $this->cellar = new Cellar($this);
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

    public function getCellar(): Cellar
    {
        return $this->cellar;
    }

    public function setCellar(Cellar $cellar): self
    {
        $this->cellar = $cellar;

        return $this;
    }
}
