<?php

namespace App\Util;

use App\Entity\User\User;
use App\Entity\Wine\Bottle;
use App\Entity\Wine\Color;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class WineData
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function getWineColors()
    {
        return $this->entityManager->getRepository(Color::class)->findAll();
    }

    public function getWineColorsInCellar()
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $cellar = $user->getCellar();

        $data = [];
        foreach ($this->getWineColors() as $wineColor) {
            $data[$wineColor->getSlug()] = ['count' => 0, 'entity' => $wineColor];
        }

        foreach ($cellar->getBottles() as $bottle) {
            if ($bottle->getStatus() == Bottle::STATUS_FULL) {
                $data[$bottle->getWine()->getColor()->getSlug()]['count']++;
            }
        }

        return $data;
    }

    public function getWineConsumption(string $year)
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        if(is_null($year)) {
            $year = (new \DateTime('now'))->format('Y');
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->entityManager->getRepository(Bottle::class)->getWineConsumption($user->getCellar(), $year);
    }

    public function getWineConsumptionYears()
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->entityManager->getRepository(Bottle::class)->getWineConsumptionYears($user->getCellar());
    }
}