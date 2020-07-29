<?php

namespace App\Listener\Wine;

use App\Entity\Wine\Appellation;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class AppellationListener
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var Slugify */
    private $slugify;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->slugify = new Slugify();
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof Appellation) {
            $entity->setSlug($this->slugify->slugify($entity->getName()));
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof Appellation) {
            $entity->setSlug($this->slugify->slugify($entity->getName()));
        }
    }

    public function onFlush(OnFlushEventArgs $onFlushEventArgs)
    {
        $unitOfWork = $onFlushEventArgs->getEntityManager()->getUnitOfWork();
    }
}