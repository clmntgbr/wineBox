<?php

namespace App\Listener\Wine;

use App\Entity\Wine\Wine;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class WineListener
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof Wine) {
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof Wine) {
        }
    }

    public function onFlush(OnFlushEventArgs $onFlushEventArgs)
    {
        $unitOfWork = $onFlushEventArgs->getEntityManager()->getUnitOfWork();
    }
}